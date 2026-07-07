<?php

namespace Tests\Feature\Admin;

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class MenusControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;

    public function test_index_is_forbidden_without_menu_access(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.menus.index'))->assertForbidden();
    }

    public function test_store_creates_a_menu_and_syncs_submenuses(): void
    {
        $this->actingAsUserWithPermissions(['menu_create']);
        $submenu = Submenu::factory()->create();

        // "position" não está nas regras de StoreMenuRequest, mas a coluna
        // é NOT NULL sem default — o formulário real calcula esse valor
        // via JS antes do submit.
        $response = $this->post(route('admin.menus.store'), [
            'title' => 'Serviços',
            'position' => 10,
            'link_type' => '0',
            'submenuses' => [$submenu->id],
        ]);

        $response->assertRedirect(route('admin.menus.index'));
        $menu = Menu::whereTitle('Serviços')->firstOrFail();
        $this->assertTrue($menu->submenuses->contains($submenu));
    }

    public function test_store_requires_a_unique_title(): void
    {
        $this->actingAsUserWithPermissions(['menu_create']);
        Menu::factory()->create(['title' => 'Início']);

        $this->post(route('admin.menus.store'), [
            'title' => 'Início',
            'link_type' => '2',
        ])->assertSessionHasErrors('title');
    }

    public function test_reorder_updates_the_position_when_authorized(): void
    {
        $this->actingAsUserWithPermissions(['menu_edit']);
        $menu = Menu::factory()->create(['position' => 1]);

        $this->post(route('admin.menus.reorder'), ['id' => $menu->id, 'position' => 5])
            ->assertRedirect(route('admin.menus.index'));

        $this->assertDatabaseHas('menus', ['id' => $menu->id, 'position' => 5]);
    }

    public function test_reorder_is_forbidden_without_menu_edit_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $menu = Menu::factory()->create(['position' => 1]);

        $this->post(route('admin.menus.reorder'), ['id' => $menu->id, 'position' => 5])->assertForbidden();

        $this->assertDatabaseHas('menus', ['id' => $menu->id, 'position' => 1]);
    }

    public function test_destroy_soft_deletes_the_menu(): void
    {
        $this->actingAsUserWithPermissions(['menu_delete']);
        $menu = Menu::factory()->create();

        $this->delete(route('admin.menus.destroy', $menu))->assertRedirect();

        $this->assertSoftDeleted('menus', ['id' => $menu->id]);
    }
}
