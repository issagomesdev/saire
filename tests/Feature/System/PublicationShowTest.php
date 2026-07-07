<?php

namespace Tests\Feature\System;

use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_page_loads_for_an_existing_publication(): void
    {
        Publication::factory()->create(['title' => 'Prefeitura entrega nova UBS']);

        $this->get('/noticias/Prefeitura_entrega_nova_UBS')->assertOk();
    }

    /**
     * Antes da correção, um slug inexistente causava um erro fatal
     * (SitesController::show() chamava ->created_at num $publication nulo).
     */
    public function test_unknown_slug_returns_404_instead_of_a_fatal_error(): void
    {
        $this->get('/noticias/isso_nao_existe')->assertNotFound();
    }
}
