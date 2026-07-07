<?php

namespace Tests\Feature\Admin;

use App\Models\Submenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class SubmenusControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;

    public function test_index_is_forbidden_without_submenu_access(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.submenus.index'))->assertForbidden();
    }

    public function test_store_creates_a_submenu(): void
    {
        $this->actingAsUserWithPermissions(['submenu_create']);

        // "position" não está nas regras de StoreSubmenuRequest, mas a
        // coluna é NOT NULL sem default — o formulário real calcula esse
        // valor via JS antes do submit.
        $response = $this->post(route('admin.submenus.store'), [
            'title' => 'Segunda Via de IPTU',
            'position' => 1,
            'link_type' => '1',
            'url' => 'https://exemplo.gov.br/iptu',
        ]);

        $response->assertRedirect(route('admin.submenus.index'));
        $this->assertDatabaseHas('submenus', ['title' => 'Segunda Via de IPTU']);
    }

    public function test_store_is_forbidden_without_submenu_create_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->post(route('admin.submenus.store'), ['title' => 'X', 'link_type' => '1'])->assertForbidden();
    }

    public function test_reorder_updates_the_position_when_authorized(): void
    {
        $this->actingAsUserWithPermissions(['submenu_edit']);
        $submenu = Submenu::factory()->create(['position' => 1]);

        $this->post(route('admin.submenus.reorder'), ['id' => $submenu->id, 'position' => 9])
            ->assertRedirect(route('admin.submenus.index'));

        $this->assertDatabaseHas('submenus', ['id' => $submenu->id, 'position' => 9]);
    }

    public function test_reorder_is_forbidden_without_submenu_edit_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $submenu = Submenu::factory()->create(['position' => 1]);

        $this->post(route('admin.submenus.reorder'), ['id' => $submenu->id, 'position' => 9])->assertForbidden();

        $this->assertDatabaseHas('submenus', ['id' => $submenu->id, 'position' => 1]);
    }

    public function test_destroy_soft_deletes_the_submenu(): void
    {
        $this->actingAsUserWithPermissions(['submenu_delete']);
        $submenu = Submenu::factory()->create();

        $this->delete(route('admin.submenus.destroy', $submenu))->assertRedirect();

        $this->assertSoftDeleted('submenus', ['id' => $submenu->id]);
    }
}
