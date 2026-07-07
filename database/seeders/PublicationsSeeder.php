<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Publication;
use Database\Seeders\Support\LinkedGalleryRegistry;
use Database\Seeders\Support\MediaCatalog;
use Database\Seeders\Support\MunicipalTopics;
use Database\Seeders\Support\NewsContentGenerator;
use Database\Seeders\Support\SeedDateGenerator;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PublicationsSeeder extends Seeder
{
    private const TOTAL = 150;

    private const GALLERY_WORTHY_CAP = 45;

    private const FEATURED_COUNT = 10;

    public function run()
    {
        $faker = Factory::create('pt_BR');
        $categoryIds = Category::pluck('id', 'title');
        $mediaCatalog = new MediaCatalog(database_path('fake_media'));
        $generator = new NewsContentGenerator($faker);
        $dateGenerator = new SeedDateGenerator($faker, now());

        $topics = MunicipalTopics::all();
        $weightedTopics = $this->expandByWeight($topics);
        // As primeiras iterações consomem cada tópico uma vez (embaralhado),
        // garantindo cobertura total antes de sortear com peso para as demais.
        $guaranteedOrder = collect($topics)->shuffle();
        $galleryWorthyCount = 0;

        for ($i = 0; $i < self::TOTAL; $i++) {
            $topic = $i < $guaranteedOrder->count()
                ? $guaranteedOrder[$i]
                : $faker->randomElement($weightedTopics);

            $date = $dateGenerator->randomDate($topic['season'] ?? null, $topic['years'] ?? null);
            $content = $generator->generate($topic, $faker->numberBetween(300, 900));

            $publication = Publication::create([
                'title' => $content['title'],
                'text' => $content['html'],
                'status' => false,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $categoryIdsForTopic = collect($topic['categories'])
                ->map(fn (string $title) => $categoryIds[$title] ?? null)
                ->filter()
                ->values();
            $publication->categories()->sync($categoryIdsForTopic);

            if (empty($topic['skip_media']) && $faker->boolean(80)) {
                $photoPaths = $mediaCatalog->imagesForTheme($topic['media_theme'], $faker->numberBetween(1, 6));
                foreach ($photoPaths as $path) {
                    // preservingOriginal(): o arquivo em database/fake_media e um
                    // acervo reutilizavel entre varias publications/galleries, nao
                    // um upload descartavel — sem isso o Spatie moveria (apagaria)
                    // o arquivo de origem apos o primeiro uso.
                    $publication->addMedia($path)->preservingOriginal()->toMediaCollection('photos');
                }
            }

            if (! empty($topic['gallery_worthy']) && $galleryWorthyCount < self::GALLERY_WORTHY_CAP && $faker->boolean(70)) {
                LinkedGalleryRegistry::register(
                    $content['title'],
                    $categoryIdsForTopic->all(),
                    $date,
                    $topic['media_theme'],
                    null,
                );
                $galleryWorthyCount++;
            }
        }

        // "status" = destaque/fav na home (ver resources/views/admin/publications
        // e o botão de favoritar do PublicationsController::favPublications).
        // Apenas as publicações mais recentes ficam em destaque; update() direto
        // na query builder evita disparar o evento "updated" do Auditable para
        // cada uma das 150 publicações.
        Publication::query()
            ->orderByDesc('created_at')
            ->take(self::FEATURED_COUNT)
            ->update(['status' => true]);
    }

    private function expandByWeight(array $topics): array
    {
        $expanded = [];

        foreach ($topics as $topic) {
            for ($i = 0, $weight = $topic['weight'] ?? 1; $i < $weight; $i++) {
                $expanded[] = $topic;
            }
        }

        return $expanded;
    }
}
