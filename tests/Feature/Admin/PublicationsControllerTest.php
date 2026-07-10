<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\BuildsDataTablesRequests;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class PublicationsControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;
    use BuildsDataTablesRequests;

    public function test_index_is_forbidden_without_publication_access(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.publications.index'))->assertForbidden();
    }

    public function test_store_creates_a_publication_and_syncs_categories(): void
    {
        $this->actingAsUserWithPermissions(['publication_create']);
        $category = Category::factory()->create();

        $response = $this->post(route('admin.publications.store'), [
            'title' => 'Prefeitura inaugura nova praça',
            'text' => '<p>Texto da notícia.</p>',
            'categories' => [$category->id],
        ]);

        $response->assertRedirect(route('admin.publications.index'));
        $publication = Publication::whereTitle('Prefeitura inaugura nova praça')->firstOrFail();
        $this->assertTrue($publication->categories->contains($category));
    }

    public function test_store_is_forbidden_without_publication_create_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->post(route('admin.publications.store'), ['title' => 'X', 'text' => 'Y'])->assertForbidden();
    }

    public function test_title_with_underline_is_rejected(): void
    {
        $this->actingAsUserWithPermissions(['publication_create']);

        $this->post(route('admin.publications.store'), [
            'title' => 'Titulo_invalido',
            'text' => '<p>Texto</p>',
        ])->assertSessionHasErrors('title');
    }

    public function test_store_attaches_a_photo_from_the_tmp_uploads_staging_path(): void
    {
        $this->actingAsUserWithPermissions(['publication_create']);
        $stagedFile = $this->stageTmpUpload('foto.jpg');

        $this->post(route('admin.publications.store'), [
            'title' => 'Publicação com foto',
            'text' => '<p>Texto</p>',
            'photos' => [$stagedFile],
        ])->assertRedirect(route('admin.publications.index'));

        $publication = Publication::whereTitle('Publicação com foto')->firstOrFail();
        $this->assertCount(1, $publication->getMedia('photos'));
    }

    public function test_update_removes_photos_no_longer_present_in_the_request(): void
    {
        $this->actingAsUserWithPermissions(['publication_edit']);
        $publication = Publication::factory()->create();
        $staged = $this->stageTmpUpload('original.jpg');
        $publication->addMedia(storage_path('tmp/uploads/'.$staged))->preservingOriginal()->toMediaCollection('photos');

        $this->put(route('admin.publications.update', $publication), [
            'title' => $publication->title,
            'text' => $publication->text,
            'photos' => [],
        ])->assertRedirect(route('admin.publications.index'));

        $this->assertCount(0, $publication->fresh()->getMedia('photos'));
    }

    public function test_fav_publications_toggles_status_when_authorized(): void
    {
        $this->actingAsUserWithPermissions(['publication_edit']);
        $publication = Publication::factory()->create(['status' => false]);

        $this->get(route('admin.publications.favpublications', [
            'id' => $publication->id,
            'status' => 1,
        ]))->assertCreated();

        $this->assertDatabaseHas('publications', ['id' => $publication->id, 'status' => 1]);
    }

    public function test_fav_publications_is_forbidden_without_publication_edit_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $publication = Publication::factory()->create(['status' => false]);

        $this->get(route('admin.publications.favpublications', [
            'id' => $publication->id,
            'status' => 1,
        ]))->assertForbidden();

        $this->assertDatabaseHas('publications', ['id' => $publication->id, 'status' => 0]);
    }

    public function test_destroy_soft_deletes_the_publication(): void
    {
        $this->actingAsUserWithPermissions(['publication_delete']);
        $publication = Publication::factory()->create();

        $this->delete(route('admin.publications.destroy', $publication))->assertRedirect();

        $this->assertSoftDeleted('publications', ['id' => $publication->id]);
    }

    /**
     * Regressão: a coluna virtual "fav" (addColumn, sem coluna real) e as
     * colunas "placeholder"/"actions" quebravam a busca global do Yajra
     * com "Unknown column" antes do searchable:false; "categories" tem o
     * mesmo problema de relação sem JOIN que Gallery/Users.
     */
    public function test_ajax_global_search_and_categories_sort_do_not_error(): void
    {
        $this->actingAsUserWithPermissions(['publication_access']);
        $category = Category::factory()->create(['title' => 'Educação']);
        $publication = Publication::factory()->create(['title' => 'Escola nova é inaugurada']);
        $publication->categories()->sync([$category->id]);
        Publication::factory()->create(['title' => 'Outra notícia']);

        $columns = ['placeholder', 'fav', 'id', 'title', 'categories', 'created_at', 'updated_at', 'actions'];

        $searchUrl = $this->dataTablesUrl(route('admin.publications.index'), $columns, 'Escola');
        $searchResponse = $this->getDataTablesJson($searchUrl)->assertOk();
        $this->assertSame(1, $searchResponse->json('recordsFiltered'));

        // indice 4 = "categories" nesta view (tem uma coluna "fav" a mais
        // que as outras, entao o indice do id/categories nao e o mesmo
        // das demais listagens)
        $orderUrl = $this->dataTablesUrl(route('admin.publications.index'), $columns, '', [], [4, 'asc']);
        $this->getDataTablesJson($orderUrl)->assertOk();
    }

    /**
     * O fluxo real (MediaUploadingTrait) primeiro move o upload para
     * storage/tmp/uploads/{uniqid}_{nome} antes do controller anexar via
     * addMedia() — replicamos só a parte que o controller espera encontrar.
     * Precisa ser um PNG válido de verdade: o Spatie Media Library gera as
     * conversões "thumb"/"preview" via GD no momento do addMedia(), e bytes
     * inválidos fariam essa etapa falhar.
     */
    private function stageTmpUpload(string $filename): string
    {
        $stagedName = uniqid().'_'.$filename;
        $path = storage_path('tmp/uploads');
        if (! is_dir($path)) {
            mkdir($path, 0777, true);
        }
        // PNG 1x1 transparente válido.
        $onePixelPng = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
        file_put_contents($path.'/'.$stagedName, $onePixelPng);

        return $stagedName;
    }
}
