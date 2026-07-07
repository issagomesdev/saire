<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Gallery;
use Database\Seeders\Support\LinkedGalleryRegistry;
use Database\Seeders\Support\MediaCatalog;
use Database\Seeders\Support\SeedDateGenerator;
use Faker\Factory;
use Illuminate\Database\Seeder;

class GalleriesSeeder extends Seeder
{
    private const TOTAL = 100;

    /**
     * Galerias temáticas avulsas, usadas para completar o total após as
     * galerias "vinculadas" (ver LinkedGalleryRegistry). Várias variações
     * de título por tema evitam repetição quando o mesmo tema é sorteado
     * mais de uma vez — o ano da data gerada também entra no título.
     */
    private const STANDALONE_GALLERIES = [
        [
            'titles' => ['Festa de São João', 'Arraiá Municipal', 'São João na Praça'],
            'categories' => ['Cultura', 'Festividades'],
            'media_theme' => MediaCatalog::THEME_SAO_JOAO,
            'season' => [6],
        ],
        [
            'titles' => ['Carnaval de Rua', 'Bloco Oficial do Carnaval'],
            'categories' => ['Cultura', 'Festividades'],
            'media_theme' => MediaCatalog::THEME_FESTIVIDADES_POPULARES,
            'season' => [2, 3],
        ],
        [
            'titles' => ['Natal Iluminado', 'Chegada do Papai Noel'],
            'categories' => ['Festividades', 'Eventos'],
            'media_theme' => MediaCatalog::THEME_FESTIVIDADES_POPULARES,
            'season' => [12],
        ],
        [
            'titles' => ['Desfile Cívico de 7 de Setembro', 'Semana da Pátria'],
            'categories' => ['Cultura', 'Festividades', 'Administração'],
            'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
            'season' => [9],
        ],
        [
            'titles' => ['Festa do Padroeiro', 'Procissão e Festa Religiosa'],
            'categories' => ['Cultura', 'Festividades'],
            'media_theme' => MediaCatalog::THEME_CULTURA_POPULAR,
            'season' => null,
        ],
        [
            'titles' => ['Corrida Municipal', 'Corrida de Rua pelo Centro Histórico'],
            'categories' => ['Esporte', 'Turismo'],
            'media_theme' => MediaCatalog::THEME_ESPORTE,
            'season' => null,
        ],
        [
            'titles' => ['Campeonato Municipal de Futebol', 'Torneio Municipal de Esportes'],
            'categories' => ['Esporte', 'Juventude'],
            'media_theme' => MediaCatalog::THEME_ESPORTE,
            'season' => null,
        ],
        [
            'titles' => ['Reforma da Escola Municipal', 'Entrega de Escola Reformada'],
            'categories' => ['Educação', 'Obras'],
            'media_theme' => MediaCatalog::THEME_EDUCACAO,
            'season' => null,
        ],
        [
            'titles' => ['Obra de Pavimentação', 'Ruas Pavimentadas'],
            'categories' => ['Infraestrutura', 'Obras'],
            'media_theme' => MediaCatalog::THEME_OBRAS_INFRAESTRUTURA,
            'season' => null,
        ],
        [
            'titles' => ['Inauguração da UBS', 'Nova Unidade Básica de Saúde'],
            'categories' => ['Saúde', 'Obras'],
            'media_theme' => MediaCatalog::THEME_SAUDE,
            'season' => null,
        ],
        [
            'titles' => ['Mutirão de Limpeza', 'Ação Comunitária de Limpeza Urbana'],
            'categories' => ['Limpeza Urbana', 'Meio Ambiente'],
            'media_theme' => MediaCatalog::THEME_MEIO_AMBIENTE,
            'season' => null,
        ],
        [
            'titles' => ['Campanha de Vacinação', 'Mutirão de Vacinação'],
            'categories' => ['Vacinação', 'Saúde'],
            'media_theme' => MediaCatalog::THEME_VACINACAO,
            'season' => null,
        ],
        [
            'titles' => ['Arborização Urbana', 'Plantio de Mudas Nativas'],
            'categories' => ['Meio Ambiente'],
            'media_theme' => MediaCatalog::THEME_MEIO_AMBIENTE,
            'season' => null,
        ],
        [
            'titles' => ['Feira Livre do Produtor', 'Feira Municipal de Alimentos'],
            'categories' => ['Agricultura', 'Abastecimento'],
            'media_theme' => MediaCatalog::THEME_AGRICULTURA_FEIRA,
            'season' => null,
        ],
        [
            'titles' => ['Feira de Artesanato', 'Feira de Economia Criativa'],
            'categories' => ['Cultura', 'Turismo', 'Desenvolvimento Econômico'],
            'media_theme' => MediaCatalog::THEME_CULTURA_POPULAR,
            'season' => null,
        ],
        [
            'titles' => ['Formatura de Alunos da Rede Municipal', 'Colação de Grau'],
            'categories' => ['Educação'],
            'media_theme' => MediaCatalog::THEME_EDUCACAO,
            'season' => null,
        ],
        [
            'titles' => ['Turma de Capacitação Profissional', 'Curso Profissionalizante Gratuito'],
            'categories' => ['Capacitação', 'Empreendedorismo'],
            'media_theme' => MediaCatalog::THEME_EDUCACAO,
            'season' => null,
        ],
        [
            'titles' => ['Audiência Pública do Orçamento', 'Audiência Pública Municipal'],
            'categories' => ['Audiências Públicas', 'Transparência'],
            'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
            'season' => null,
        ],
        [
            'titles' => ['Entrega de Novas Viaturas', 'Renovação da Frota de Segurança'],
            'categories' => ['Segurança', 'Defesa Civil'],
            'media_theme' => MediaCatalog::THEME_SEGURANCA_DEFESA_CIVIL,
            'season' => null,
        ],
        [
            'titles' => ['Entrega de Ambulância', 'Nova Ambulância para o Município'],
            'categories' => ['Saúde', 'Defesa Civil'],
            'media_theme' => MediaCatalog::THEME_SEGURANCA_DEFESA_CIVIL,
            'season' => null,
        ],
        [
            'titles' => ['Ação da Defesa Civil', 'Prevenção em Áreas de Risco'],
            'categories' => ['Defesa Civil', 'Segurança'],
            'media_theme' => MediaCatalog::THEME_SEGURANCA_DEFESA_CIVIL,
            'season' => [11, 12, 1, 2, 3],
        ],
        [
            'titles' => ['Nova Iluminação de LED', 'Praça com Iluminação Renovada'],
            'categories' => ['Iluminação Pública', 'Infraestrutura'],
            'media_theme' => MediaCatalog::THEME_OBRAS_INFRAESTRUTURA,
            'season' => null,
        ],
        [
            'titles' => ['Campanha Outubro Rosa', 'Ações de Prevenção à Saúde da Mulher'],
            'categories' => ['Saúde', 'Campanhas', 'Mulher'],
            'media_theme' => MediaCatalog::THEME_SAUDE,
            'season' => [10],
        ],
        [
            'titles' => ['Campanha Novembro Azul', 'Ações de Prevenção à Saúde do Homem'],
            'categories' => ['Saúde', 'Campanhas'],
            'media_theme' => MediaCatalog::THEME_SAUDE,
            'season' => [11],
        ],
        [
            'titles' => ['Feira de Adoção de Animais', 'Cães e Gatos Esperam por um Lar'],
            'categories' => ['Proteção Animal', 'Saúde Animal'],
            'media_theme' => MediaCatalog::THEME_ANIMAIS_PROTECAO,
            'season' => null,
        ],
        [
            'titles' => ['Festa do Peão', 'Rodeio Municipal'],
            'categories' => ['Cultura', 'Festividades', 'Eventos'],
            'media_theme' => MediaCatalog::THEME_FESTIVIDADES_POPULARES,
            'season' => null,
        ],
        [
            'titles' => ['Torneios Esportivos Municipais', 'Copa Municipal de Esportes'],
            'categories' => ['Esporte'],
            'media_theme' => MediaCatalog::THEME_ESPORTE,
            'season' => null,
        ],
        [
            'titles' => ['Inclusão pelo Esporte', 'Torneio Paradesportivo'],
            'categories' => ['Esporte', 'Inclusão Social'],
            'media_theme' => MediaCatalog::THEME_ESPORTE,
            'season' => null,
        ],
        [
            'titles' => ['Recuperação de Estradas Rurais', 'Apoio ao Homem do Campo'],
            'categories' => ['Agricultura Familiar', 'Desenvolvimento Rural'],
            'media_theme' => MediaCatalog::THEME_AGRICULTURA_FEIRA,
            'season' => null,
        ],
        [
            'titles' => ['Eventos Diversos da Prefeitura', 'Registro de Atividades Municipais'],
            'categories' => ['Eventos', 'Comunicação'],
            'media_theme' => MediaCatalog::THEME_EVENTOS_DIVERSOS,
            'season' => null,
        ],
    ];

    public function run()
    {
        $faker = Factory::create('pt_BR');
        $categoryIds = Category::pluck('id', 'title');
        $mediaCatalog = new MediaCatalog(database_path('fake_media'));
        $dateGenerator = new SeedDateGenerator($faker, now());
        $eventGroups = $mediaCatalog->eventGroups();

        $created = 0;

        foreach (LinkedGalleryRegistry::all() as $linked) {
            if ($created >= self::TOTAL) {
                break;
            }

            $this->createGallery(
                title: 'Galeria: '.$linked['title'],
                description: 'Registro fotográfico do evento noticiado em "'.$linked['title'].'".',
                date: $linked['date'],
                categoryIds: $linked['category_ids'],
                photoPaths: $this->pickPhotosForLinkedGallery($linked, $eventGroups, $mediaCatalog, $faker),
            );

            $created++;
        }

        while ($created < self::TOTAL) {
            $definition = $faker->randomElement(self::STANDALONE_GALLERIES);
            $date = $dateGenerator->randomDate($definition['season']);

            $categoryIdsForGallery = collect($definition['categories'])
                ->map(fn (string $title) => $categoryIds[$title] ?? null)
                ->filter()
                ->values()
                ->all();

            $this->createGallery(
                title: $faker->randomElement($definition['titles']).' '.$date->year,
                description: 'Galeria de fotos do evento realizado em '.$date->translatedFormat('F \\d\\e Y').'.',
                date: $date,
                categoryIds: $categoryIdsForGallery,
                photoPaths: $mediaCatalog->imagesForTheme($definition['media_theme'], $faker->numberBetween(5, 20)),
            );

            $created++;
        }
    }

    private function createGallery(string $title, string $description, $date, array $categoryIds, array $photoPaths): void
    {
        $gallery = Gallery::create([
            'title' => $title,
            'description' => $description,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $gallery->categories()->sync($categoryIds);

        foreach ($photoPaths as $path) {
            // preservingOriginal(): mesmo motivo do PublicationsSeeder — o
            // arquivo de origem e reaproveitado por varias galerias/publicações.
            $gallery->addMedia($path)->preservingOriginal()->toMediaCollection('photos');
        }
    }

    /**
     * @param array{title: string, category_ids: int[], date: \Carbon\Carbon, theme: string, event_group: ?string} $linked
     * @return string[]
     */
    private function pickPhotosForLinkedGallery(array $linked, $eventGroups, MediaCatalog $mediaCatalog, $faker): array
    {
        $targetCount = $faker->numberBetween(5, 20);
        $images = $linked['event_group'] !== null
            ? array_values($eventGroups->get($linked['event_group'], []))
            : [];

        if (count($images) < $targetCount) {
            $images = array_unique(array_merge(
                $images,
                $mediaCatalog->imagesForTheme($linked['theme'], $targetCount - count($images))
            ));
        }

        return array_slice($images, 0, $targetCount);
    }
}
