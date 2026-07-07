<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    private const THEMES = [
        'Festa de São João', 'Carnaval de Rua', 'Natal Iluminado', 'Desfile Cívico',
        'Corrida Municipal', 'Reforma da Escola Municipal', 'Feira Livre do Produtor',
        'Campanha de Vacinação', 'Arborização Urbana', 'Audiência Pública Municipal',
    ];

    public function definition(): array
    {
        $faker = FakerFactory::create('pt_BR');

        return [
            'title' => $faker->randomElement(self::THEMES).' '.$faker->numberBetween(2023, 2026),
            'description' => $faker->sentence(12),
        ];
    }
}
