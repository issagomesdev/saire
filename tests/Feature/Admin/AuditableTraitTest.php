<?php

namespace Tests\Feature\Admin;

use App\Models\AuditLog;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * App\Traits\Auditable (usada por Publication, Gallery, Category, Menu,
 * Submenu, User, Role) grava uma linha em audit_logs a cada
 * created/updated/deleted. Category é o model mais simples para exercitar
 * isso sem precisar de mídia/relacionamentos extras.
 */
class AuditableTraitTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_model_writes_an_audit_log(): void
    {
        $category = Category::create(['title' => 'Saúde']);

        $this->assertDatabaseHas('audit_logs', [
            'description' => 'Cadastro',
            'subject_id' => $category->id,
            'subject_type' => 'Category',
        ]);
    }

    public function test_updating_a_model_writes_an_audit_log(): void
    {
        $category = Category::create(['title' => 'Saúde']);

        $category->update(['title' => 'Saúde Pública']);

        $this->assertDatabaseHas('audit_logs', [
            'description' => 'Edição',
            'subject_id' => $category->id,
            'subject_type' => 'Category',
        ]);
    }

    public function test_deleting_a_model_writes_an_audit_log(): void
    {
        $category = Category::create(['title' => 'Saúde']);

        $category->delete();

        $this->assertDatabaseHas('audit_logs', [
            'description' => 'Exclusão',
            'subject_id' => $category->id,
            'subject_type' => 'Category',
        ]);
    }

    public function test_audit_log_stores_the_authenticated_user_id(): void
    {
        // User::factory()->create() também dispara Auditable (User usa a
        // trait), e cada tabela tem seu próprio auto-increment — então
        // $user->id e $category->id podem coincidir. Filtrar só por
        // subject_id não é suficiente, precisa também de subject_type.
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $category = Category::create(['title' => 'Educação']);

        $log = AuditLog::where('subject_id', $category->id)
            ->where('subject_type', 'Category')
            ->where('description', 'Cadastro')
            ->firstOrFail();
        $this->assertSame($user->id, $log->user_id);
    }
}
