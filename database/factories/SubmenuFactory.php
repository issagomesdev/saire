<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submenu>
 */
class SubmenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            // "position" e UNIQUE na tabela.
            'title' => ucfirst(fake()->words(2, true)),
            'position' => fake()->unique()->numberBetween(1, 1000),
            'link_type' => '1',
            'url' => '/'.fake()->slug(),
            'page_id' => null,
        ];
    }
}
