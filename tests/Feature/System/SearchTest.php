<?php

namespace Tests\Feature\System;

use App\Models\Gallery;
use App\Models\Page;
use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * A página de busca (site.search) só renderiza o shell — os resultados
 * chegam via 3 endpoints AJAX registrados como closures em routes/web.php
 * (/pesquisa/publications, /pesquisa/pages, /pesquisa/galleries), sem nome
 * de rota, por isso testados pela URL literal.
 */
class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_page_loads_successfully(): void
    {
        $this->get(route('site.search', ['search' => 'praça']))->assertOk();
    }

    public function test_publications_search_endpoint_filters_by_title(): void
    {
        Publication::factory()->create(['title' => 'Prefeitura inaugura nova praça']);
        Publication::factory()->create(['title' => 'Campanha de vacinação contra a gripe']);

        $response = $this->getJson('/pesquisa/publications?search=praça');

        $response->assertOk();
        $titles = collect($response->json('data'))->pluck('title');
        $this->assertTrue($titles->contains('Prefeitura inaugura nova praça'));
        $this->assertFalse($titles->contains('Campanha de vacinação contra a gripe'));
    }

    public function test_pages_search_endpoint_filters_by_title(): void
    {
        Page::factory()->create(['title' => 'Município']);
        Page::factory()->create(['title' => 'Secretarias']);

        $response = $this->getJson('/pesquisa/pages?search=Munic');

        $response->assertOk();
        $titles = collect($response->json('data'))->pluck('title');
        $this->assertTrue($titles->contains('Município'));
        $this->assertFalse($titles->contains('Secretarias'));
    }

    public function test_galleries_search_endpoint_filters_by_title(): void
    {
        Gallery::factory()->create(['title' => 'Festa de São João']);
        Gallery::factory()->create(['title' => 'Carnaval de Rua']);

        $response = $this->getJson('/pesquisa/galleries?search=João');

        $response->assertOk();
        $titles = collect($response->json('data'))->pluck('title');
        $this->assertTrue($titles->contains('Festa de São João'));
        $this->assertFalse($titles->contains('Carnaval de Rua'));
    }
}
