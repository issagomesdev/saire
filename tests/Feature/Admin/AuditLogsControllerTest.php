<?php

namespace Tests\Feature\Admin;

use App\Models\AuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class AuditLogsControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;

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
}
