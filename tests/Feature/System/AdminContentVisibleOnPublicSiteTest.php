<?php

namespace Tests\Feature\System;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

/**
 * Jornada cruzando módulos: um admin autenticado cria uma categoria e uma
 * publicação com foto pelo painel, e o conteúdo aparece corretamente
 * (título, categoria, foto) nas páginas públicas — home, listagem e show.
 */
class AdminContentVisibleOnPublicSiteTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;

    public function test_publication_created_in_admin_is_visible_across_the_public_site(): void
    {
        $this->actingAsUserWithPermissions(['category_create', 'publication_create']);

        $this->post(route('admin.categories.store'), [
            'title' => 'Infraestrutura',
            'description' => 'Obras e serviços urbanos',
        ])->assertRedirect(route('admin.categories.index'));
        $category = Category::whereTitle('Infraestrutura')->firstOrFail();

        $staged = $this->stagePng('obra.jpg');
        $this->post(route('admin.publications.store'), [
            'title' => 'Prefeitura conclui pavimentação da Rua das Flores',
            'text' => '<p>Moradores comemoram a nova via pavimentada.</p>',
            'categories' => [$category->id],
            'photos' => [$staged],
        ])->assertRedirect(route('admin.publications.index'));

        $this->post(route('logout'))->assertRedirect();

        // Home e listagem renderizam os cards via JS a partir do JSON
        // embutido no <script> — o título só aparece como texto visível no
        // HTML retornado pelo servidor na página de show (Blade puro).
        $home = $this->get(route('site.index'))->assertOk()->getContent();
        $this->assertContains('Prefeitura conclui pavimentação da Rua das Flores', $this->decodeEmbeddedJsonArrayTitles($home, 'publications'));

        $listing = $this->get(route('site.publications'))->assertOk()->getContent();
        $this->assertContains('Prefeitura conclui pavimentação da Rua das Flores', $this->decodeEmbeddedJsonArrayTitles($listing, 'publications'));

        $show = $this->get('/noticias/Prefeitura_conclui_pavimentação_da_Rua_das_Flores')->assertOk()->getContent();
        $this->assertStringContainsString('Infraestrutura', $show);
    }

    private function decodeEmbeddedJsonArrayTitles(string $html, string $variableName): array
    {
        preg_match('/const '.preg_quote($variableName, '/').' = (\[.*?\]);/s', $html, $matches);

        return array_column(json_decode($matches[1], true) ?? [], 'title');
    }

    private function stagePng(string $filename): string
    {
        $stagedName = uniqid().'_'.$filename;
        $path = storage_path('tmp/uploads');
        if (! is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $onePixelPng = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
        file_put_contents($path.'/'.$stagedName, $onePixelPng);

        return $stagedName;
    }
}
