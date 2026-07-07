<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

/**
 * PermissionsController só expõe index/show/massDestroy via rota nomeada
 * (Route::resource(..., ['except' => ['create','store','edit','update','destroy']])
 * em routes/web.php) — os permissões são gerenciadas via PermissionsTableSeeder,
 * não pelo CRUD do admin.
 */
class PermissionsControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;

    public function test_index_is_forbidden_without_permission_access(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.permissions.index'))->assertForbidden();
    }

    public function test_index_is_visible_with_permission_access(): void
    {
        $this->actingAsUserWithPermissions(['permission_access']);

        $this->get(route('admin.permissions.index'))->assertOk();
    }

    public function test_show_is_forbidden_without_permission_show(): void
    {
        $this->actingAsUserWithoutPermissions();
        $permission = Permission::factory()->create();

        $this->get(route('admin.permissions.show', $permission))->assertForbidden();
    }

    public function test_show_is_visible_with_permission_show(): void
    {
        $this->actingAsUserWithPermissions(['permission_show']);
        $permission = Permission::factory()->create();

        $this->get(route('admin.permissions.show', $permission))->assertOk();
    }

    public function test_mass_destroy_deletes_multiple_permissions(): void
    {
        $this->actingAsUserWithPermissions(['permission_delete']);
        $permissions = Permission::factory()->count(3)->create();

        $this->delete(route('admin.permissions.massDestroy'), ['ids' => $permissions->pluck('id')->all()])
            ->assertNoContent();

        foreach ($permissions as $permission) {
            $this->assertSoftDeleted('permissions', ['id' => $permission->id]);
        }
    }

    public function test_mass_destroy_is_forbidden_without_permission_delete(): void
    {
        $this->actingAsUserWithoutPermissions();
        $permission = Permission::factory()->create();

        $this->delete(route('admin.permissions.massDestroy'), ['ids' => [$permission->id]])->assertForbidden();
    }
}
