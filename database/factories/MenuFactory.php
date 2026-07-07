<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            // "title" e "position" sao UNIQUE na tabela — precisam de valores
            // unicos por registro mesmo em fabricas em lote.
            'title' => ucfirst(fake()->unique()->words(2, true)),
            'position' => fake()->unique()->numberBetween(1, 1000),
            'link_type' => '2',
            'url' => '/'.fake()->slug(),
            'page_id' => null,
        ];
    }
}
