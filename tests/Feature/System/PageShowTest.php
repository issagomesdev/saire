<?php

namespace Tests\Feature\System;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_page_loads_for_an_existing_page(): void
    {
        Page::factory()->create(['title' => 'Município']);

        $this->get('/pagina/Município')->assertOk();
    }

    /**
     * Antes da correção, um slug inexistente causava erro fatal em
     * SitesController::page() (Page::where(...)->first() retornava null).
     */
    public function test_unknown_slug_returns_404_instead_of_a_fatal_error(): void
    {
        $this->get('/pagina/isso_nao_existe')->assertNotFound();
    }
}
