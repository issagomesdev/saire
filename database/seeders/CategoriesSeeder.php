<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Categorias institucionais fixas, compartilhadas por Publications e
     * Galleries (mesma tabela, ver App\Models\Category). Inseridas via
     * insert() (bulk, sem eventos Eloquent) para não gerar ~55 linhas de
     * audit_log desnecessárias no primeiro boot — mesmo padrão já usado
     * por PermissionsTableSeeder/RolesTableSeeder/UsersTableSeeder.
     */
    private const CATEGORIES = [
        'Saúde', 'Educação', 'Assistência Social', 'Cultura', 'Esporte', 'Turismo',
        'Agricultura', 'Infraestrutura', 'Obras', 'Mobilidade Urbana', 'Trânsito',
        'Segurança', 'Meio Ambiente', 'Defesa Civil', 'Administração',
        'Gabinete do Prefeito', 'Finanças', 'Planejamento', 'Desenvolvimento Econômico',
        'Habitação', 'Juventude', 'Mulher', 'Pessoa Idosa', 'Criança e Adolescente',
        'Inclusão Social', 'Direitos Humanos', 'Eventos', 'Festividades', 'Licitações',
        'Transparência', 'Comunicação', 'Convênios', 'Saúde Animal', 'Proteção Animal',
        'Serviços Urbanos', 'Iluminação Pública', 'Limpeza Urbana', 'Recursos Hídricos',
        'Tecnologia', 'Governo Digital', 'Capacitação', 'Empreendedorismo',
        'Agricultura Familiar', 'Desenvolvimento Rural', 'Abastecimento',
        'Audiências Públicas', 'Campanhas', 'Vacinação', 'Combate à Dengue',
        'Processo Seletivo', 'Concursos', 'Notas Oficiais', 'Notas de Pesar',
        'Decretos', 'Portarias', 'Boletins Epidemiológicos',
    ];

    public function run()
    {
        $now = now();

        Category::insert(array_map(fn (string $title) => [
            'title' => $title,
            'description' => "Publicações e galerias relacionadas a {$title}.",
            'created_at' => $now,
            'updated_at' => $now,
        ], self::CATEGORIES));
    }
}
