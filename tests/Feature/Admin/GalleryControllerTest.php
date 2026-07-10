<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\BuildsDataTablesRequests;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class GalleryControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;
    use BuildsDataTablesRequests;

    public function test_index_is_forbidden_without_gallery_access(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.galleries.index'))->assertForbidden();
    }

    public function test_store_creates_a_gallery_and_syncs_categories(): void
    {
        $this->actingAsUserWithPermissions(['gallery_create']);
        $category = Category::factory()->create();
        $staged = $this->stagePng('foto.jpg');

        $response = $this->post(route('admin.galleries.store'), [
            'title' => 'Festa de São João 2024',
            'description' => 'Fotos do arraiá municipal.',
            'categories' => [$category->id],
            'photos' => [$staged],
        ]);

        $response->assertRedirect(route('admin.galleries.index'));
        $gallery = Gallery::whereTitle('Festa de São João 2024')->firstOrFail();
        $this->assertTrue($gallery->categories->contains($category));
    }

    public function test_store_is_forbidden_without_gallery_create_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->post(route('admin.galleries.store'), ['title' => 'X'])->assertForbidden();
    }

    public function test_store_attaches_a_photo(): void
    {
        $this->actingAsUserWithPermissions(['gallery_create']);
        $category = Category::factory()->create();
        $staged = $this->stagePng('foto.jpg');

        $this->post(route('admin.galleries.store'), [
            'title' => 'Galeria com foto',
            'description' => 'Descrição',
            'categories' => [$category->id],
            'photos' => [$staged],
        ])->assertRedirect(route('admin.galleries.index'));

        $gallery = Gallery::whereTitle('Galeria com foto')->firstOrFail();
        $this->assertCount(1, $gallery->getMedia('photos'));
    }

    public function test_update_changes_the_gallery(): void
    {
        $this->actingAsUserWithPermissions(['gallery_edit']);
        $category = Category::factory()->create();
        $gallery = Gallery::factory()->create(['title' => 'Original']);
        $staged = $this->stagePng('foto.jpg');

        $this->put(route('admin.galleries.update', $gallery), [
            'title' => 'Atualizada',
            'description' => $gallery->description,
            'categories' => [$category->id],
            'photos' => [$staged],
        ])->assertRedirect(route('admin.galleries.index'));

        $this->assertDatabaseHas('galleries', ['id' => $gallery->id, 'title' => 'Atualizada']);
    }

    public function test_destroy_soft_deletes_the_gallery(): void
    {
        $this->actingAsUserWithPermissions(['gallery_delete']);
        $gallery = Gallery::factory()->create();

        $this->delete(route('admin.galleries.destroy', $gallery))->assertRedirect();

        $this->assertSoftDeleted('galleries', ['id' => $gallery->id]);
    }

    public function test_destroy_is_forbidden_without_gallery_delete_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $gallery = Gallery::factory()->create();

        $this->delete(route('admin.galleries.destroy', $gallery))->assertForbidden();
    }

    /**
     * Regressão: "categories" é declarada com nome dot-notation
     * ("categories.title") mas a query base só faz with(), sem JOIN —
     * sem filterColumn/orderColumn, buscar ou ordenar por essa coluna
     * gerava "Unknown column" no MySQL.
     */
    public function test_ajax_search_and_sort_by_categories_relation_does_not_error(): void
    {
        $this->actingAsUserWithPermissions(['gallery_access']);
        $category = Category::factory()->create(['title' => 'Esportes']);
        $gallery = Gallery::factory()->create(['title' => 'Galeria de esportes']);
        $gallery->categories()->sync([$category->id]);
        Gallery::factory()->create(['title' => 'Outra galeria']);

        $columns = ['placeholder', 'id', 'title', 'categories', 'created_at', 'updated_at', 'actions'];

        $searchUrl = $this->dataTablesUrl(route('admin.galleries.index'), $columns, 'Esportes');
        $searchResponse = $this->getDataTablesJson($searchUrl)->assertOk();
        $this->assertSame(1, $searchResponse->json('recordsFiltered'));

        $orderUrl = $this->dataTablesUrl(route('admin.galleries.index'), $columns, '', [], [3, 'asc']);
        $this->getDataTablesJson($orderUrl)->assertOk();
    }

    /**
     * Regressão: editColumn('photos') acessava $row->photos sem eager
     * load de "media" — 1 query extra por linha exibida na página.
     */
    public function test_index_does_not_trigger_n_plus_one_queries_for_photos(): void
    {
        $this->actingAsUserWithPermissions(['gallery_access']);
        foreach (range(1, 5) as $i) {
            $gallery = Gallery::factory()->create();
            $staged = $this->stagePng("foto{$i}.jpg");
            $gallery->addMedia(storage_path('tmp/uploads/'.$staged))->preservingOriginal()->toMediaCollection('photos');
        }

        DB::enableQueryLog();
        $columns = ['placeholder', 'id', 'title', 'categories', 'created_at', 'updated_at', 'actions'];
        $this->getDataTablesJson($this->dataTablesUrl(route('admin.galleries.index'), $columns))->assertOk();
        $queryCount = count(DB::getQueryLog());
        DB::disableQueryLog();

        // Sem o eager load de "media", seriam >= 5 queries extras (1 por
        // galeria) além das queries normais do Yajra — o teto generoso
        // aqui só precisa provar que a contagem não escala com N.
        $this->assertLessThan(15, $queryCount);
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
