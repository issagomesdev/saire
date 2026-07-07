<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->word().'_'.fake()->randomElement(['create', 'edit', 'show', 'delete', 'access']);

        return [
            'title' => $title,
            'lab' => ucfirst(str_replace('_', ' ', $title)),
        ];
    }
}
