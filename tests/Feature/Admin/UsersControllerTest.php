<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAdminUser;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;
    use CreatesAdminUser;

    public function test_index_is_forbidden_without_user_access_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_index_is_visible_with_user_access_permission(): void
    {
        $this->actingAsUserWithPermissions(['user_access']);

        $this->get(route('admin.users.index'))->assertOk();
    }

    public function test_store_creates_a_user_and_syncs_roles(): void
    {
        $this->actingAsUserWithPermissions(['user_create']);
        $role = Role::factory()->create();

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Fulana da Silva',
            'email' => 'fulana@example.com',
            'password' => 'senha-forte',
            'roles' => [$role->id],
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $user = User::whereEmail('fulana@example.com')->firstOrFail();
        $this->assertTrue($user->roles->contains($role));
    }

    public function test_store_is_forbidden_without_user_create_permission(): void
    {
        $this->actingAsUserWithoutPermissions();

        $this->post(route('admin.users.store'), ['name' => 'X'])->assertForbidden();
    }

    public function test_store_requires_a_unique_email(): void
    {
        $this->actingAsUserWithPermissions(['user_create']);
        $existing = User::factory()->create(['email' => 'ja-existe@example.com']);
        $role = Role::factory()->create();

        $this->post(route('admin.users.store'), [
            'name' => 'Outro',
            'email' => 'ja-existe@example.com',
            'password' => 'senha-forte',
            'roles' => [$role->id],
        ])->assertSessionHasErrors('email');
    }

    public function test_update_changes_the_user_and_resyncs_roles(): void
    {
        $this->actingAsUserWithPermissions(['user_edit']);
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $this->put(route('admin.users.update', $user), [
            'name' => 'Nome Atualizado',
            'email' => $user->email,
            'roles' => [$role->id],
        ])->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Nome Atualizado']);
        $this->assertTrue($user->fresh()->roles->contains($role));
    }

    public function test_destroy_soft_deletes_the_user(): void
    {
        $this->actingAsUserWithPermissions(['user_delete']);
        $user = User::factory()->create();

        $this->delete(route('admin.users.destroy', $user))->assertRedirect();

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_destroy_is_forbidden_without_user_delete_permission(): void
    {
        $this->actingAsUserWithoutPermissions();
        $user = User::factory()->create();

        $this->delete(route('admin.users.destroy', $user))->assertForbidden();
    }
}
