<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class RolesControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;

    public function test_index_is_forbidden_without_role_access_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.roles.index'))->assertForbidden();
    }

    public function test_store_creates_a_role_and_syncs_permissions(): void
    {
        $this->actingAsUserWithPermissions(['role_create']);
        $permission = Permission::factory()->create();

        $response = $this->post(route('admin.roles.store'), [
            'title' => 'Editor',
            'permissions' => [$permission->id],
        ]);

        $response->assertRedirect(route('admin.roles.index'));
        $role = Role::whereTitle('Editor')->firstOrFail();
        $this->assertTrue($role->permissions->contains($permission));
    }

    public function test_store_is_forbidden_without_role_create_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->post(route('admin.roles.store'), ['title' => 'Editor'])->assertForbidden();
        $this->assertDatabaseMissing('roles', ['title' => 'Editor']);
    }

    public function test_update_resyncs_permissions(): void
    {
        $this->actingAsUserWithPermissions(['role_edit']);
        $role = Role::factory()->create();
        $permission = Permission::factory()->create();

        $this->put(route('admin.roles.update', $role), [
            'title' => $role->title,
            'permissions' => [$permission->id],
        ])->assertRedirect(route('admin.roles.index'));

        $this->assertTrue($role->fresh()->permissions->contains($permission));
    }

    public function test_show_is_forbidden_without_role_show_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $role = Role::factory()->create();

        $this->get(route('admin.roles.show', $role))->assertForbidden();
    }

    public function test_destroy_soft_deletes_the_role(): void
    {
        $this->actingAsUserWithPermissions(['role_delete']);
        $role = Role::factory()->create();

        $this->delete(route('admin.roles.destroy', $role))->assertRedirect();

        $this->assertSoftDeleted('roles', ['id' => $role->id]);
    }
}
