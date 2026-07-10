<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\BuildsDataTablesRequests;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;
    use BuildsDataTablesRequests;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.categories.index'))->assertRedirect(route('login'));
    }

    public function test_index_is_forbidden_without_category_access_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.categories.index'))->assertForbidden();
    }

    public function test_index_is_visible_with_category_access_permission(): void
    {
        $this->actingAsUserWithPermissions(['category_access']);

        $this->get(route('admin.categories.index'))->assertOk();
    }

    public function test_store_creates_a_category(): void
    {
        $this->actingAsUserWithPermissions(['category_create']);

        $response = $this->post(route('admin.categories.store'), [
            'title' => 'Saúde',
            'description' => 'Notícias e galerias de saúde',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['title' => 'Saúde']);
    }

    public function test_store_is_forbidden_without_category_create_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->post(route('admin.categories.store'), ['title' => 'Saúde'])->assertForbidden();
        $this->assertDatabaseMissing('categories', ['title' => 'Saúde']);
    }

    public function test_store_requires_a_title(): void
    {
        $this->actingAsUserWithPermissions(['category_create']);

        $this->post(route('admin.categories.store'), [])->assertSessionHasErrors('title');
    }

    public function test_update_changes_the_category(): void
    {
        $this->actingAsUserWithPermissions(['category_edit']);
        $category = Category::factory()->create(['title' => 'Original']);

        $this->put(route('admin.categories.update', $category), ['title' => 'Atualizado'])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'title' => 'Atualizado']);
    }

    public function test_update_is_forbidden_without_category_edit_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $category = Category::factory()->create(['title' => 'Original']);

        $this->put(route('admin.categories.update', $category), ['title' => 'Atualizado'])->assertForbidden();
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'title' => 'Original']);
    }

    public function test_show_is_forbidden_without_category_show_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $category = Category::factory()->create();

        $this->get(route('admin.categories.show', $category))->assertForbidden();
    }

    public function test_destroy_soft_deletes_the_category(): void
    {
        $this->actingAsUserWithPermissions(['category_delete']);
        $category = Category::factory()->create();

        $this->delete(route('admin.categories.destroy', $category))->assertRedirect();

        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }

    public function test_destroy_is_forbidden_without_category_delete_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $category = Category::factory()->create();

        $this->delete(route('admin.categories.destroy', $category))->assertForbidden();
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'deleted_at' => null]);
    }

    public function test_mass_destroy_deletes_multiple_categories(): void
    {
        $this->actingAsUserWithPermissions(['category_delete']);
        $categories = Category::factory()->count(3)->create();

        $this->delete(route('admin.categories.massDestroy'), ['ids' => $categories->pluck('id')->all()])
            ->assertNoContent();

        foreach ($categories as $category) {
            $this->assertSoftDeleted('categories', ['id' => $category->id]);
        }
    }

    /**
     * Regressão: "placeholder" e "actions" são colunas virtuais (sem
     * coluna real no banco) presentes em toda listagem server-side do
     * admin. Sem "searchable: false" nelas, a busca global do Yajra
     * gerava "WHERE placeholder LIKE ..." e quebrava com erro de SQL —
     * em qualquer módulo, mesmo pesquisando um termo válido.
     */
    public function test_ajax_global_search_does_not_error_on_virtual_columns(): void
    {
        $this->actingAsUserWithPermissions(['category_access']);
        Category::factory()->create(['title' => 'Saúde Pública']);
        Category::factory()->create(['title' => 'Educação']);

        $url = $this->dataTablesUrl(
            route('admin.categories.index'),
            ['placeholder', 'id', 'title', 'created_at', 'updated_at', 'actions'],
            'Saúde'
        );

        $response = $this->getDataTablesJson($url)->assertOk();
        $this->assertSame(1, $response->json('recordsFiltered'));
    }
}
