<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['id' => 1, 'title' => 'user_management_access', 'lab' => 'Acesso à gestão de usuários'],
            ['id' => 2, 'title' => 'permission_create', 'lab' => 'Criar permissão'],
            ['id' => 3, 'title' => 'permission_edit', 'lab' => 'Editar permissão'],
            ['id' => 4, 'title' => 'permission_show', 'lab' => 'Visualizar permissão'],
            ['id' => 5, 'title' => 'permission_delete', 'lab' => 'Excluir permissão'],
            ['id' => 6, 'title' => 'permission_access', 'lab' => 'Acesso a permissões'],
            ['id' => 7, 'title' => 'role_create', 'lab' => 'Criar perfil'],
            ['id' => 8, 'title' => 'role_edit', 'lab' => 'Editar perfil'],
            ['id' => 9, 'title' => 'role_show', 'lab' => 'Visualizar perfil'],
            ['id' => 10, 'title' => 'role_delete', 'lab' => 'Excluir perfil'],
            ['id' => 11, 'title' => 'role_access', 'lab' => 'Acesso a perfis'],
            ['id' => 12, 'title' => 'user_create', 'lab' => 'Criar usuário'],
            ['id' => 13, 'title' => 'user_edit', 'lab' => 'Editar usuário'],
            ['id' => 14, 'title' => 'user_show', 'lab' => 'Visualizar usuário'],
            ['id' => 15, 'title' => 'user_delete', 'lab' => 'Excluir usuário'],
            ['id' => 16, 'title' => 'user_access', 'lab' => 'Acesso a usuários'],
            ['id' => 17, 'title' => 'site_access', 'lab' => 'Acesso ao painel administrativo'],
            ['id' => 18, 'title' => 'navigation_access', 'lab' => 'Acesso ao menu de navegação'],
            ['id' => 19, 'title' => 'publication_create', 'lab' => 'Criar publicação'],
            ['id' => 20, 'title' => 'publication_edit', 'lab' => 'Editar publicação'],
            ['id' => 21, 'title' => 'publication_show', 'lab' => 'Visualizar publicação'],
            ['id' => 22, 'title' => 'publication_delete', 'lab' => 'Excluir publicação'],
            ['id' => 23, 'title' => 'publication_access', 'lab' => 'Acesso a publicações'],
            ['id' => 24, 'title' => 'category_create', 'lab' => 'Criar categoria'],
            ['id' => 25, 'title' => 'category_edit', 'lab' => 'Editar categoria'],
            ['id' => 26, 'title' => 'category_show', 'lab' => 'Visualizar categoria'],
            ['id' => 27, 'title' => 'category_delete', 'lab' => 'Excluir categoria'],
            ['id' => 28, 'title' => 'category_access', 'lab' => 'Acesso a categorias'],
            ['id' => 29, 'title' => 'gallery_create', 'lab' => 'Criar galeria'],
            ['id' => 30, 'title' => 'gallery_edit', 'lab' => 'Editar galeria'],
            ['id' => 31, 'title' => 'gallery_show', 'lab' => 'Visualizar galeria'],
            ['id' => 32, 'title' => 'gallery_delete', 'lab' => 'Excluir galeria'],
            ['id' => 33, 'title' => 'gallery_access', 'lab' => 'Acesso a galerias'],
            ['id' => 34, 'title' => 'audit_log_show', 'lab' => 'Visualizar log de auditoria'],
            ['id' => 35, 'title' => 'audit_log_access', 'lab' => 'Acesso a logs de auditoria'],
            ['id' => 36, 'title' => 'profile_password_edit', 'lab' => 'Editar senha do perfil'],
            ['id' => 37, 'title' => 'menu_create', 'lab' => 'Criar menu'],
            ['id' => 38, 'title' => 'menu_edit', 'lab' => 'Editar menu'],
            ['id' => 39, 'title' => 'menu_show', 'lab' => 'Visualizar menu'],
            ['id' => 40, 'title' => 'menu_delete', 'lab' => 'Excluir menu'],
            ['id' => 41, 'title' => 'menu_access', 'lab' => 'Acesso a menus'],
            ['id' => 42, 'title' => 'submenu_create', 'lab' => 'Criar submenu'],
            ['id' => 43, 'title' => 'submenu_edit', 'lab' => 'Editar submenu'],
            ['id' => 44, 'title' => 'submenu_show', 'lab' => 'Visualizar submenu'],
            ['id' => 45, 'title' => 'submenu_delete', 'lab' => 'Excluir submenu'],
            ['id' => 46, 'title' => 'submenu_access', 'lab' => 'Acesso a submenus'],
            ['id' => 47, 'title' => 'page_create', 'lab' => 'Criar página'],
            ['id' => 48, 'title' => 'page_edit', 'lab' => 'Editar página'],
            ['id' => 49, 'title' => 'page_show', 'lab' => 'Visualizar página'],
            ['id' => 50, 'title' => 'page_delete', 'lab' => 'Excluir página'],
            ['id' => 51, 'title' => 'page_access', 'lab' => 'Acesso a páginas'],
        ];

        Permission::insert($permissions);
    }
}
