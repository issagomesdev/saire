<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Roda em toda requisicao autenticada do grupo "web" (inclusive cada
     * "draw" AJAX do DataTables), entao a leitura de roles/permissions
     * fica cacheada em vez de reconsultar o banco a cada request. Invalidada
     * explicitamente em RolesController/PermissionsController quando
     * roles/permissions mudam (ver self::CACHE_KEY).
     */
    public const CACHE_KEY = 'auth-gates-permissions';

    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (! $user) {
            return $next($request);
        }

        $permissionsArray = Cache::remember(self::CACHE_KEY, now()->addMinutes(10), function () {
            $roles            = Role::with('permissions')->get();
            $permissionsArray = [];

            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsArray[$permissions->title][] = $role->id;
                }
            }

            return $permissionsArray;
        });

        foreach ($permissionsArray as $title => $roles) {
            Gate::define($title, function ($user) use ($roles) {
                return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
            });
        }

        return $next($request);
    }
}
