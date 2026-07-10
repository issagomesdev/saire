<?php

namespace Tests\Feature\Admin;

use App\Models\AuditLog;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\BuildsDataTablesRequests;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class AuditLogsControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;
    use BuildsDataTablesRequests;

    public function test_index_is_forbidden_without_audit_log_access(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.audit-logs.index'))->assertForbidden();
    }

    public function test_index_is_visible_with_audit_log_access(): void
    {
        $this->actingAsUserWithPermissions(['audit_log_access']);

        $this->get(route('admin.audit-logs.index'))->assertOk();
    }

    public function test_show_is_forbidden_without_audit_log_show(): void
    {
        $this->actingAsUserWithoutPermissions();
        $log = AuditLog::create(['description' => 'Cadastro', 'subject_type' => 'Category']);

        $this->get(route('admin.audit-logs.show', $log))->assertForbidden();
    }

    public function test_show_is_visible_with_audit_log_show(): void
    {
        $this->actingAsUserWithPermissions(['audit_log_show']);
        $log = AuditLog::create(['description' => 'Cadastro', 'subject_type' => 'Category']);

        $this->get(route('admin.audit-logs.show', $log))->assertOk();
    }

    /**
     * audit_logs agora usa Yajra server-side (antes era AuditLog::all()
     * sem paginação, o maior risco de degradação já que a tabela cresce
     * indefinidamente). Os links de subject/user que antes eram lógica
     * Blade viraram editColumn no controller — testa o caminho feliz.
     */
    public function test_ajax_index_renders_subject_and_user_links(): void
    {
        $admin = $this->actingAsUserWithPermissions(['audit_log_access']);
        $category = Category::factory()->create();
        $log = AuditLog::create([
            'description' => 'Cadastro',
            'subject_id' => $category->id,
            'subject_type' => 'Category',
            'user_id' => $admin->id,
        ]);

        $columns = ['placeholder', 'id', 'description', 'subject_id', 'subject_type', 'user_id', 'host', 'created_at', 'actions'];
        $response = $this->getDataTablesJson($this->dataTablesUrl(route('admin.audit-logs.index'), $columns))->assertOk();

        $row = collect($response->json('data'))->firstWhere('id', $log->id);
        $this->assertStringContainsString(route('admin.categories.show', $category->id), $row['subject_id']);
        $this->assertStringContainsString(route('admin.users.show', $admin->id), $row['user_id']);
    }

    /**
     * Regressão: audit logs sem subject_id/user_id (comum quando a ação
     * não está atrelada a um request HTTP autenticado, ex.: seeders) não
     * pode quebrar a listagem.
     */
    public function test_ajax_index_handles_missing_subject_and_user_gracefully(): void
    {
        $this->actingAsUserWithPermissions(['audit_log_access']);
        AuditLog::create(['description' => 'Cadastro', 'subject_type' => 'Category']);

        $columns = ['placeholder', 'id', 'description', 'subject_id', 'subject_type', 'user_id', 'host', 'created_at', 'actions'];

        $this->getDataTablesJson($this->dataTablesUrl(route('admin.audit-logs.index'), $columns))->assertOk();
    }
}
