<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Estrutura de navegação real do site original da Prefeitura de Sairé.
     * Nenhum menu usa submenus na prática (menu_submenu está vazio na base
     * original) — todos usam link_type "1" (Página Interna, via page_id)
     * ou "2" (Página Externa, via url).
     */
    public function run()
    {
        Menu::insert([
            [
                'id' => 1,
                'title' => 'Portal da Transparência',
                'position' => 6,
                'link_type' => '2',
                'url' => 'https://transparencia.saire.pe.gov.br/portal/v81/p_index/p_index.php',
                'created_at' => '2023-03-04 20:23:38',
                'updated_at' => '2023-03-04 20:23:38',
                'deleted_at' => null,
                'page_id' => null,
            ],
            [
                'id' => 3,
                'title' => 'Ouvidoria',
                'position' => 7,
                'link_type' => '2',
                'url' => 'https://transparencia.saire.pe.gov.br/portal/v81/p_acesso_rapido/p_acesso_rapido.php',
                'created_at' => '2023-03-04 20:26:05',
                'updated_at' => '2023-03-04 20:26:05',
                'deleted_at' => null,
                'page_id' => null,
            ],
            [
                'id' => 6,
                'title' => 'Secretarias',
                'position' => 4,
                'link_type' => '1',
                'url' => null,
                'created_at' => '2023-03-05 01:32:42',
                'updated_at' => '2023-03-05 01:32:42',
                'deleted_at' => null,
                'page_id' => 3,
            ],
            [
                'id' => 7,
                'title' => 'Governo Municipal',
                'position' => 3,
                'link_type' => '1',
                'url' => null,
                'created_at' => '2023-03-05 01:33:00',
                'updated_at' => '2023-03-05 01:33:00',
                'deleted_at' => null,
                'page_id' => 2,
            ],
            [
                'id' => 8,
                'title' => 'Município',
                'position' => 2,
                'link_type' => '1',
                'url' => null,
                'created_at' => '2023-03-05 01:33:11',
                'updated_at' => '2023-03-05 01:33:11',
                'deleted_at' => null,
                'page_id' => 1,
            ],
            [
                'id' => 10,
                'title' => 'Notícias',
                'position' => 5,
                'link_type' => '2',
                'url' => '/noticias',
                'created_at' => '2023-03-05 01:36:55',
                'updated_at' => '2023-03-05 02:00:09',
                'deleted_at' => null,
                'page_id' => null,
            ],
            [
                'id' => 13,
                'title' => 'Inicio',
                'position' => 1,
                'link_type' => '2',
                'url' => '/',
                'created_at' => '2023-03-06 21:39:45',
                'updated_at' => '2023-03-06 21:39:45',
                'deleted_at' => null,
                'page_id' => null,
            ],
        ]);
    }
}
