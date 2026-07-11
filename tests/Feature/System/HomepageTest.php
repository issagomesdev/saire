<?php

namespace Tests\Feature\System;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $this->get(route('site.index'))->assertOk();
    }

    /**
     * Skeleton Loading: os containers de destaques/galeria/notícias
     * precisam vir com skeleton já no HTML inicial (antes de qualquer
     * JS rodar) — é isso que evita o "flash" de conteúdo vazio.
     */
    public function test_homepage_renders_skeleton_placeholders_before_js_runs(): void
    {
        $html = $this->get(route('site.index'))->assertOk()->getContent();

        $this->assertStringContainsString('skeleton', $html);
        $this->assertMatchesRegularExpression('/<div class="features">.*?skeleton.*?<\/div>/s', $html);
        $this->assertMatchesRegularExpression('/<div class="images">.*?skeleton.*?<\/div>/s', $html);
        $this->assertMatchesRegularExpression('/<div class="publications">.*?skeleton.*?<\/div>/s', $html);
    }

    /**
     * A home renderiza os cards via JS lendo os blocos JSON embutidos no
     * <script> (site/script.js) — o HTML retornado pelo servidor não contém
     * os títulos como texto visível, então o teste decodifica o mesmo JSON
     * que o navegador consumiria.
     */
    public function test_homepage_embeds_recent_and_featured_publications_and_galleries(): void
    {
        $category = Category::factory()->create();
        $featured = Publication::factory()->create(['title' => 'Publicação em destaque', 'status' => true]);
        $featured->categories()->sync([$category->id]);
        $recent = Publication::factory()->create(['title' => 'Publicação recente', 'status' => false]);
        $gallery = Gallery::factory()->create(['title' => 'Galeria de teste']);

        $html = $this->get(route('site.index'))->assertOk()->getContent();

        $this->assertContains('Publicação recente', $this->decodeEmbeddedJsonArrayTitles($html, 'publications'));
        $this->assertContains('Publicação em destaque', $this->decodeEmbeddedJsonArrayTitles($html, 'featuredPublications'));
        $this->assertContains('Galeria de teste', $this->decodeEmbeddedJsonArrayTitles($html, 'galleries'));
    }

    /**
     * Regressão do bug corrigido em site/index.blade.php: o texto gerado
     * pelos seeders tem parágrafos separados por quebra de linha real, e a
     * interpolação manual antiga (sem @json()) quebrava a sintaxe do
     * <script>, deixando a home sem nenhum card renderizado mesmo com dados
     * corretos no banco.
     */
    public function test_embedded_publications_json_is_valid_even_with_multiline_text(): void
    {
        Publication::factory()->create([
            'text' => "<p>Primeiro parágrafo com \"aspas\".</p>\n<p>Segundo parágrafo em outra linha.</p>",
        ]);

        $html = $this->get(route('site.index'))->assertOk()->getContent();

        $this->assertJsonArrayIsEmbeddedAndValid($html, 'publications');
        $this->assertJsonArrayIsEmbeddedAndValid($html, 'featuredPublications');
        $this->assertJsonArrayIsEmbeddedAndValid($html, 'galleries');
    }

    private function assertJsonArrayIsEmbeddedAndValid(string $html, string $variableName): void
    {
        $this->assertMatchesRegularExpression(
            '/const '.preg_quote($variableName, '/').' = (\[.*?\]);/s',
            $html,
            "expected a 'const {$variableName} = [...]' block in the rendered HTML"
        );

        preg_match('/const '.preg_quote($variableName, '/').' = (\[.*?\]);/s', $html, $matches);

        $decoded = json_decode($matches[1], true);

        $this->assertNotNull($decoded, "embedded JSON for '{$variableName}' failed to parse: ".json_last_error_msg());
    }

    private function decodeEmbeddedJsonArrayTitles(string $html, string $variableName): array
    {
        preg_match('/const '.preg_quote($variableName, '/').' = (\[.*?\]);/s', $html, $matches);

        return array_column(json_decode($matches[1], true) ?? [], 'title');
    }
}
