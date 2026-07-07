<?php

namespace Tests\Unit\Seeders\Support;

use Database\Seeders\Support\NewsContentGenerator;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class NewsContentGeneratorTest extends TestCase
{
    private function topic(array $overrides = []): array
    {
        return array_merge([
            'titles' => ['Prefeitura pavimenta a Rua {street}'],
            'intro_templates' => ['Moradores de {neighborhood} comemoram a novidade.'],
            'facts' => [
                'investimento de {money} em recursos próprios',
                'pavimentação de {number} metros de extensão',
                'redução de {percentage}% no acúmulo de poeira',
                'apoio da equipe da {school}',
            ],
            'quote_roles' => ['Secretário de Obras'],
        ], $overrides);
    }

    public function test_title_comes_from_topic_titles(): void
    {
        $generator = new NewsContentGenerator(Factory::create('pt_BR'));

        $result = $generator->generate($this->topic(['titles' => ['Título fixo de teste']]), 300);

        $this->assertSame('Título fixo de teste', $result['title']);
    }

    public function test_placeholders_are_replaced_and_never_leak_into_output(): void
    {
        $generator = new NewsContentGenerator(Factory::create('pt_BR'));

        $result = $generator->generate($this->topic(), 300);

        foreach (['{street}', '{neighborhood}', '{money}', '{number}', '{percentage}', '{school}', '{name}', '{role}'] as $placeholder) {
            $this->assertStringNotContainsString($placeholder, $result['title'].$result['html']);
        }
    }

    public function test_html_is_wrapped_in_paragraph_tags(): void
    {
        $generator = new NewsContentGenerator(Factory::create('pt_BR'));

        $result = $generator->generate($this->topic(), 300);

        $this->assertStringStartsWith('<p>', $result['html']);
        $this->assertStringContainsString('</p>', $result['html']);
    }

    public function test_body_grows_towards_target_word_count_within_paragraph_cap(): void
    {
        $generator = new NewsContentGenerator(Factory::create('pt_BR'));

        $result = $generator->generate($this->topic(), 900);
        $wordCount = str_word_count(strip_tags($result['html']));

        // O gerador para de adicionar parágrafos ao atingir o alvo, mas
        // nunca passa de 8 parágrafos (ver NewsContentGenerator::generate);
        // com poucos "facts" no fixture, o alvo de 900 palavras não é
        // necessariamente atingido — o que importa é que o texto realmente
        // cresce em vez de parar no primeiro parágrafo.
        $this->assertGreaterThan(20, $wordCount);
    }

    public function test_list_label_produces_an_unordered_list(): void
    {
        $generator = new NewsContentGenerator(Factory::create('pt_BR'));

        $result = $generator->generate($this->topic([
            'list_label' => 'Confira os destaques:',
        ]), 300);

        $this->assertStringContainsString('<ul>', $result['html']);
        $this->assertStringContainsString('<li>', $result['html']);
    }

    public function test_subheading_is_rendered_as_h3(): void
    {
        $generator = new NewsContentGenerator(Factory::create('pt_BR'));

        $result = $generator->generate($this->topic([
            'subheading' => 'Detalhes da obra',
        ]), 300);

        $this->assertStringContainsString('<h3>Detalhes da obra</h3>', $result['html']);
    }
}
