<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $faker = FakerFactory::create('pt_BR');
        $title = $faker->unique()->randomElement([
            'Saúde', 'Educação', 'Cultura', 'Esporte', 'Turismo', 'Meio Ambiente',
            'Infraestrutura', 'Assistência Social', 'Segurança', 'Agricultura',
        ]);

        return [
            'title' => $title,
            'description' => "Publicações e galerias relacionadas a {$title}.",
        ];
    }
}
