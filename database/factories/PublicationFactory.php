<?php

namespace Database\Factories;

use Database\Seeders\Support\MunicipalTopics;
use Database\Seeders\Support\NewsContentGenerator;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Reaproveita o mesmo gerador de conteúdo usado por PublicationsSeeder
 * (NewsContentGenerator + MunicipalTopics), para que `Publication::factory()`
 * continue produzindo notícias realistas em PT-BR fora do fluxo de seed
 * principal (ex.: em testes ou no tinker), sem duplicar a lógica de texto.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    public function definition(): array
    {
        $faker = FakerFactory::create('pt_BR');
        $topic = $faker->randomElement(MunicipalTopics::all());
        $content = (new NewsContentGenerator($faker))->generate($topic, $faker->numberBetween(300, 900));

        return [
            'title' => $content['title'],
            'text' => $content['html'],
            'status' => $faker->boolean(30),
        ];
    }
}
