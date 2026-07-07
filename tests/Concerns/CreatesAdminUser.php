<?php

namespace Tests\Concerns;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

/**
 * Autorização no projeto não usa Policies nem middleware `permission:xxx` —
 * os Gates são definidos dinamicamente a cada request por
 * App\Http\Middleware\AuthGates a partir de Role<->Permission no banco (ver
 * app/Http/Middleware/AuthGates.php). Por isso um teste de autorização
 * fiel precisa de linhas reais de User/Role/Permission, não dá pra mockar
 * o Gate diretamente.
 */
trait CreatesAdminUser
{
    /**
     * Cria e autentica um usuário com as permissões informadas (por título,
     * ex.: 'publication_create'). Passe [] para um usuário sem nenhuma
     * permissão (útil para testar bloqueios).
     */
    protected function actingAsUserWithPermissions(array $permissionTitles = []): User
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        if (! empty($permissionTitles)) {
            $permissions = collect($permissionTitles)->map(
                fn (string $title) => Permission::firstOrCreate(['title' => $title], ['lab' => $title])
            );
            $role->permissions()->sync($permissions->pluck('id'));
        }

        $user->roles()->sync([$role->id]);

        $this->actingAs($user);

        return $user;
    }

    /**
     * Usuário autenticado sem nenhuma role/permissão — todo Gate::denies()
     * deve retornar true para ele.
     */
    protected function actingAsUserWithoutPermissions(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }
}
