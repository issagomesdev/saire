<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class PagesControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;

    public function test_index_is_forbidden_without_page_access(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.pages.index'))->assertForbidden();
    }

    public function test_store_creates_a_page(): void
    {
        $this->actingAsUserWithPermissions(['page_create']);

        $response = $this->post(route('admin.pages.store'), [
            'title' => 'Ouvidoria',
            'content' => '<p>Fale com a Ouvidoria.</p>',
        ]);

        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', ['title' => 'Ouvidoria']);
    }

    public function test_store_is_forbidden_without_page_create_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->post(route('admin.pages.store'), ['title' => 'X', 'content' => 'Y'])->assertForbidden();
    }

    public function test_title_with_underline_is_rejected(): void
    {
        $this->actingAsUserWithPermissions(['page_create']);

        $this->post(route('admin.pages.store'), [
            'title' => 'Pagina_invalida',
            'content' => '<p>Texto</p>',
        ])->assertSessionHasErrors('title');
    }

    public function test_update_changes_the_page(): void
    {
        $this->actingAsUserWithPermissions(['page_edit']);
        $page = Page::factory()->create(['title' => 'Original']);

        $this->put(route('admin.pages.update', $page), [
            'title' => 'Atualizada',
            'content' => $page->content,
        ])->assertRedirect(route('admin.pages.index'));

        $this->assertDatabaseHas('pages', ['id' => $page->id, 'title' => 'Atualizada']);
    }

    public function test_destroy_soft_deletes_the_page(): void
    {
        $this->actingAsUserWithPermissions(['page_delete']);
        $page = Page::factory()->create();

        $this->delete(route('admin.pages.destroy', $page))->assertRedirect();

        $this->assertSoftDeleted('pages', ['id' => $page->id]);
    }

    public function test_destroy_is_forbidden_without_page_delete_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $page = Page::factory()->create();

        $this->delete(route('admin.pages.destroy', $page))->assertForbidden();
    }
}
