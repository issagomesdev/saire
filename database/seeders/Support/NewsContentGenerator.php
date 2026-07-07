<?php

namespace Database\Seeders\Support;

use Faker\Generator;

/**
 * Monta título + corpo HTML (CKEditor-compatible) de uma publicação a
 * partir de um "tópico" (ver MunicipalTopics) e do Faker pt_BR.
 *
 * A variedade textual vem de duas fontes combinadas: (1) os templates de
 * título/introdução/fechamento sao especificos de cada topico, e (2) os
 * paragrafos de desenvolvimento sao montados por conectores genericos
 * (compartilhados por todos os topicos) preenchidos com os "fatos" curtos
 * que cada topico declara — assim o mesmo topico nunca produz o mesmo
 * paragrafo duas vezes, sem exigir dezenas de paragrafos inteiros escritos
 * a mao por topico.
 */
class NewsContentGenerator
{
    /**
     * Conectores genéricos usados para transformar um "fato" curto do
     * tópico (ex.: "a troca de 40 lâmpadas por LED") em uma frase completa.
     */
    private const BODY_CONNECTORS = [
        'Segundo a administração municipal, %s.',
        'A ação contemplou %s.',
        'Entre os destaques, está %s.',
        'O investimento também garantiu %s.',
        'De acordo com a Prefeitura, a iniciativa envolveu %s.',
        'Também fez parte do pacote de medidas %s.',
        'A equipe responsável destacou %s.',
        'Um dos pontos mais comemorados pelos moradores foi %s.',
    ];

    private const CLOSING_QUOTE_TEMPLATES = [
        '"%s", declarou %s, %s.',
        'Em nota, %s, %s, afirmou que "%s".',
        'Para %s, %s, "%s".',
    ];

    public function __construct(private readonly Generator $faker)
    {
    }

    /**
     * @param array<string,mixed> $topic
     * @return array{title: string, html: string}
     */
    public function generate(array $topic, int $targetWords): array
    {
        $placeholders = $this->buildPlaceholders($topic);

        $title = $this->fill($this->faker->randomElement($topic['titles']), $placeholders);

        $paragraphs = [];
        $paragraphs[] = '<p>'.$this->fill($this->faker->randomElement($topic['intro_templates']), $placeholders).'</p>';

        $wordCount = str_word_count(strip_tags($paragraphs[0]));
        $facts = collect($topic['facts'])->shuffle()->values();
        $connectors = collect(self::BODY_CONNECTORS)->shuffle()->values();
        $factIndex = 0;
        $maxParagraphs = 8;

        if (! empty($topic['subheading'])) {
            $paragraphs[] = '<h3>'.$this->fill($topic['subheading'], $placeholders).'</h3>';
        }

        while ($wordCount < $targetWords && count($paragraphs) < $maxParagraphs) {
            if (! empty($topic['list_label']) && $factIndex === 0 && $facts->count() >= 3) {
                $listFacts = $facts->take(min(5, $facts->count()));
                $listItems = $listFacts->map(
                    fn (string $fact) => '<li>'.ucfirst($this->fill($fact, $placeholders)).'</li>'
                )->implode('');

                $introParagraph = '<p>'.$this->fill($topic['list_label'], $placeholders).'</p>';
                $listParagraph = '<ul>'.$listItems.'</ul>';
                $paragraphs[] = $introParagraph;
                $paragraphs[] = $listParagraph;
                $wordCount += str_word_count(strip_tags($introParagraph.$listParagraph));
                $factIndex = $listFacts->count();

                continue;
            }

            $fact = $facts->get($factIndex % max($facts->count(), 1), 'diversas melhorias para a população');
            $connector = $connectors->get($factIndex % $connectors->count());
            $paragraph = '<p>'.sprintf($connector, $this->fill($fact, $placeholders)).'</p>';
            $paragraphs[] = $paragraph;
            $wordCount += str_word_count(strip_tags($paragraph));
            $factIndex++;
        }

        $paragraphs[] = '<p>'.$this->buildClosing($topic, $placeholders).'</p>';

        return [
            'title' => $title,
            'html' => implode("\n", $paragraphs),
        ];
    }

    /**
     * @param array<string,mixed> $topic
     * @return array<string,string>
     */
    private function buildPlaceholders(array $topic): array
    {
        $faker = $this->faker;

        return [
            '{street}' => $faker->streetName(),
            '{neighborhood}' => $faker->randomElement([
                'Centro', 'Alto da Boa Vista', 'Vila Nova', 'Bela Vista', 'Cohab',
                'Jardim das Flores', 'São Sebastião', 'Bom Jesus', 'Novo Horizonte',
                'Planalto', 'Cajueiro', 'Boa Esperança', 'Santa Luzia',
            ]),
            '{number}' => (string) $faker->numberBetween(30, 2500),
            '{percentage}' => (string) $faker->numberBetween(15, 95),
            '{money}' => 'R$ '.number_format($faker->numberBetween(50, 900) * 1000, 0, ',', '.'),
            '{name}' => $faker->name(),
            '{role}' => $faker->randomElement($topic['quote_roles'] ?? ['secretário municipal']),
            '{school}' => 'Escola Municipal '.$faker->firstName(),
            '{days}' => (string) $faker->numberBetween(15, 180),
        ];
    }

    private function fill(string $template, array $placeholders): string
    {
        return strtr($template, $placeholders);
    }

    private function buildClosing(array $topic, array $placeholders): string
    {
        $faker = $this->faker;

        if (! empty($topic['closing_templates']) && $faker->boolean(60)) {
            return $this->fill($faker->randomElement($topic['closing_templates']), $placeholders);
        }

        $quoteFact = $faker->randomElement($topic['facts']);
        $quote = ucfirst($this->fill($faker->randomElement([
            'esse é um compromisso que a gestão pretende manter nos próximos anos',
            'a população pode contar com a continuidade desse trabalho',
            'essa é uma demanda antiga da comunidade e ficamos felizes em atendê-la',
            'seguimos investindo para melhorar a vida de quem mora aqui',
        ]), $placeholders));

        return sprintf(
            $faker->randomElement(self::CLOSING_QUOTE_TEMPLATES),
            $quote,
            $placeholders['{name}'],
            $placeholders['{role}']
        );
    }
}
