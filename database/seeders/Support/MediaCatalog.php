<?php

namespace Database\Seeders\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Classifica o acervo de fotos em database/fake_media por tema, a partir
 * do nome do arquivo, para que PublicationsSeeder/GalleriesSeeder possam
 * pedir "me dê N fotos de saude" sem nunca depender de internet.
 *
 * A classificação por palavra-chave cobre os arquivos com nome descritivo
 * (a maioria do acervo). Os arquivos com nome generico (lotes
 * "Fotográficas_realistas_eventos..." e "Realistic_photos_Brazilian_munic...")
 * não tem palavras de tema no nome — a granularidade correta ali so foi
 * possivel inspecionando uma amostra visual das imagens (feito manualmente
 * uma unica vez durante a implementação deste seeder); o resultado dessa
 * inspeção esta codificado em self::GENERIC_BATCH_RULES abaixo.
 */
class MediaCatalog
{
    public const THEME_SAUDE = 'saude';
    public const THEME_VACINACAO = 'vacinacao';
    public const THEME_EDUCACAO = 'educacao';
    public const THEME_ESPORTE = 'esporte';
    public const THEME_INCLUSAO_SOCIAL = 'inclusao_social';
    public const THEME_ASSISTENCIA_SOCIAL = 'assistencia_social';
    public const THEME_CULTURA_POPULAR = 'cultura_popular';
    public const THEME_FESTIVIDADES_POPULARES = 'festividades_populares';
    public const THEME_SAO_JOAO = 'sao_joao';
    public const THEME_CIVICO_ADMINISTRATIVO = 'civico_administrativo';
    public const THEME_SEGURANCA_DEFESA_CIVIL = 'seguranca_defesa_civil';
    public const THEME_OBRAS_INFRAESTRUTURA = 'obras_infraestrutura';
    public const THEME_MEIO_AMBIENTE = 'meio_ambiente';
    public const THEME_AGRICULTURA_FEIRA = 'agricultura_feira';
    public const THEME_ANIMAIS_PROTECAO = 'animais_protecao';
    public const THEME_EVENTOS_DIVERSOS = 'eventos_diversos';

    /**
     * Palavras-chave por tema, checadas em ordem (a primeira que bater
     * decide o tema). Ordem importa: temas mais especificos primeiro.
     */
    private const KEYWORD_RULES = [
        self::THEME_VACINACAO => ['vacin'],
        self::THEME_SAUDE => [
            'saude', 'medic', 'médic', 'enfermeir', 'dentist', 'hospital',
            'posto de saude', 'health', 'doencas', 'primeiros socorros',
            'conselho municipal saude', 'palestra conscientizacao',
            'palestra prevencao', 'transito',
        ],
        self::THEME_INCLUSAO_SOCIAL => [
            'cadeirante', 'cego', 'surdo', 'libras', 'sindrome de down',
            'síndrome de down', 'autis', 'prótese', 'protese', 'inclusiv',
            'wheelchair', 'sign language',
        ],
        self::THEME_ASSISTENCIA_SOCIAL => [
            'idoso', 'idosa', 'terceira idade', 'título de terra',
            'titulo de terra', 'cesta basica',
        ],
        self::THEME_EDUCACAO => [
            'aluno', 'escola', 'diploma', 'formatura', 'formando',
            'estudante', 'biblioteca', 'robótica', 'robotica', 'montando robô',
            'ouvindo histórias', 'explicando projeto', 'dentist_teaching',
            'pottery class', 'molding techni', 'palestra educativa',
        ],
        self::THEME_ESPORTE => [
            'futebol', 'basquete', 'basketball', 'vôlei', 'volei', 'volleyball',
            'nadador', 'nadadora', 'corredor', 'corredores', 'corrida',
            'xadrez', 'chess', 'skate', 'skatista', 'surf', 'judo', 'esgrima',
            'goalball', 'bocha', 'torneio', 'campeonato', 'competição esportiva',
            'competicao esportiva', 'ginástica', 'ginastica',
        ],
        self::THEME_SEGURANCA_DEFESA_CIVIL => [
            'bombeiro', 'guarda municipal', 'viatura', 'defesa civil',
        ],
        self::THEME_OBRAS_INFRAESTRUTURA => [
            'guias_sarj', 'iluminação', 'iluminacao', 'led_lighting',
            'mutirão_de_grafite', 'mutirao_de_grafite', 'revitaliza',
            'reforma', 'ciclovia', 'inauguration_of_public_work',
        ],
        self::THEME_MEIO_AMBIENTE => [
            'reflorestamento', 'reforestation', 'plantio', 'planting',
            'limpando_córrego', 'limpando_corrego', 'cleaning_river',
            'sustentabilidade', 'ecológica', 'ecologica',
        ],
        self::THEME_AGRICULTURA_FEIRA => [
            'produtores_rurais', 'agricultura_familiar', 'hortaliças',
            'hortalicas', 'homem_do_campo',
        ],
        self::THEME_ANIMAIS_PROTECAO => [
            'adoção_animais', 'adocao_animais', 'adoption_fair', 'animal_adoption',
            'filhote',
        ],
        self::THEME_CIVICO_ADMINISTRATIVO => [
            'desfile_cívico', 'desfile_civico', '7_de_setembro', 'semana_da_pátria',
            'câmara_municipal', 'camara_municipal', 'vereador', 'posse',
            'entrega_títulos', 'entrega_titulos', 'entrega_medalhas',
            'entrega_novas_viaturas', 'veteran', 'escoteiros', 'prefeita_',
            'prefeito_', 'authorities_cutting_ribbon', 'cerimônia_entrega',
            'cerimonia_entrega',
        ],
        self::THEME_CULTURA_POPULAR => [
            'coral_', 'orquestra', 'piseiro', 'viola_caipira', 'reisado',
            'capoeira', 'teatro', 'grafite', 'artesan', 'pintura', 'escultura',
            'banda_regional', 'banda_sinfônica', 'banda_sinfonica', 'violinista',
            'jongo', 'maracatu', 'street_theater',
        ],
        self::THEME_FESTIVIDADES_POPULARES => [
            'carnaval', 'carnival', 'festa_junina', 'festa_do_peão', 'festa_do_peao',
            'festa_das_nações', 'festa_das_nacoes', 'festival_gastron',
            'festival_regional', 'noite_de_caldos', 'quermesse', 'religious_street',
            'parish_fair', 'peão_montando_touro',
        ],
    ];

    /**
     * Lotes de nome generico (sem palavra de tema no nome de arquivo).
     * Classificados por amostragem visual manual (ver nota da classe).
     * Cada regra: prefixo do arquivo + faixa de timestamp (ou lista de
     * timestamps) => tema + event_group.
     */
    private const GENERIC_BATCH_RULES = [
        // São João / Festa Junina — fotos únicas, cena limpa e consistente.
        ['prefix' => 'Realistic_photos_Brazilian_munic', 'timestamps' => ['202607052041', '202607052042'], 'theme' => self::THEME_SAO_JOAO, 'event_group' => 'sao_joao_noite_praca'],
        // Colagens/mood-boards com legendas variadas (saude, feira, cultura
        // misturados no mesmo arquivo) — tratadas como pool generico seguro.
        ['prefix' => 'Realistic_photos_Brazilian_munic', 'timestamps' => ['202607052043', '202607052044', '202607052045', '202607052046'], 'theme' => self::THEME_EVENTOS_DIVERSOS, 'event_group' => null],
        // Festa do Peão / Feira Municipal / Festa do Divino / Desfile Cívico /
        // audiências — predominante nesse lote.
        ['prefix' => 'Fotográficas_realistas_eventos', 'timestamps' => null, 'theme' => self::THEME_FESTIVIDADES_POPULARES, 'event_group' => 'festividades_lote_b'],
    ];

    /**
     * Excecoes pontuais encontradas na amostragem visual dentro dos lotes
     * genericos acima (nome exato => tema correto).
     */
    private const GENERIC_FILE_OVERRIDES = [
        'Fotográficas_realistas_eventos_b…_202607052030 (1).jpeg' => self::THEME_ESPORTE,
        'Fotográficas_realistas_eventos_b…_202607052033.jpeg' => self::THEME_MEIO_AMBIENTE,
    ];

    private ?Collection $files = null;

    public function __construct(private readonly string $directory)
    {
    }

    /**
     * @return string[] caminhos absolutos, sem repetir dentro da mesma chamada.
     */
    public function imagesForTheme(string $theme, int $count): array
    {
        $pool = $this->files()->get($theme, collect());

        if ($pool->isEmpty()) {
            $pool = $this->files()->get(self::THEME_EVENTOS_DIVERSOS, collect());
        }

        return $pool->shuffle()->take($count)->values()->all();
    }

    /**
     * Grupos de fotos do "mesmo evento" (mesmo lote/cena), usados para
     * montar galerias coerentes com varias fotos de uma unica ocasião.
     *
     * @return Collection<string, string[]> event_group => caminhos absolutos
     */
    public function eventGroups(): Collection
    {
        return $this->allFiles()
            ->filter(fn (array $meta) => $meta['event_group'] !== null)
            ->groupBy('event_group')
            ->map(fn (Collection $group) => $group->pluck('path')->values()->all());
    }

    public function availableThemes(): array
    {
        return $this->files()->keys()->all();
    }

    /**
     * @return Collection<string, Collection> tema => coleção de caminhos absolutos
     */
    private function files(): Collection
    {
        if ($this->files !== null) {
            return $this->files;
        }

        return $this->files = $this->allFiles()->groupBy('theme')->map(
            fn (Collection $group) => $group->pluck('path')->values()
        );
    }

    /**
     * @return Collection<int, array{path: string, theme: string, event_group: ?string}>
     */
    private function allFiles(): Collection
    {
        if (! is_dir($this->directory)) {
            return collect();
        }

        $seenHashes = [];

        // GLOB_BRACE nao esta disponivel em builds PHP com musl libc (ex.:
        // php:8.3-fpm-alpine), entao um glob por extensao e mais portavel.
        $paths = collect(['jpg', 'jpeg', 'png'])
            ->flatMap(fn (string $extension) => glob("{$this->directory}/*.{$extension}") ?: []);

        return $paths
            ->filter(function (string $path) use (&$seenHashes) {
                // Descarta duplicatas exatas (mesmo conteudo, nomes diferentes).
                $hash = md5_file($path);
                if (isset($seenHashes[$hash])) {
                    return false;
                }
                $seenHashes[$hash] = true;

                return true;
            })
            ->map(fn (string $path) => [
                'path' => $path,
                'theme' => $this->classify(basename($path)),
                'event_group' => $this->eventGroupFor(basename($path)),
            ]);
    }

    private function classify(string $filename): string
    {
        if (array_key_exists($filename, self::GENERIC_FILE_OVERRIDES)) {
            return self::GENERIC_FILE_OVERRIDES[$filename];
        }

        foreach (self::GENERIC_BATCH_RULES as $rule) {
            if (! Str::startsWith($filename, $rule['prefix'])) {
                continue;
            }

            if ($rule['timestamps'] === null) {
                return $rule['theme'];
            }

            foreach ($rule['timestamps'] as $timestamp) {
                if (Str::contains($filename, $timestamp)) {
                    return $rule['theme'];
                }
            }
        }

        // Str::ascii() remove acentos (ç, ã, é...) dos dois lados da
        // comparação, e a troca de "_"/"-" por espaço vale tanto para o
        // nome do arquivo quanto para as keywords — sem isso, uma keyword
        // como "desfile_cívico" nunca bateria contra "Desfile_cívico_..."
        // normalizado para "desfile civico" (com espaço, sem acento).
        $normalized = $this->normalize($filename);

        foreach (self::KEYWORD_RULES as $theme => $keywords) {
            foreach ($keywords as $keyword) {
                if (Str::contains($normalized, $this->normalize($keyword))) {
                    return $theme;
                }
            }
        }

        return self::THEME_EVENTOS_DIVERSOS;
    }

    private function normalize(string $value): string
    {
        return Str::ascii(Str::lower(str_replace(['_', '-', '…'], ' ', $value)));
    }

    private function eventGroupFor(string $filename): ?string
    {
        foreach (self::GENERIC_BATCH_RULES as $rule) {
            if (! Str::startsWith($filename, $rule['prefix']) || $rule['event_group'] === null) {
                continue;
            }

            if ($rule['timestamps'] === null) {
                return $rule['event_group'];
            }

            foreach ($rule['timestamps'] as $timestamp) {
                if (Str::contains($filename, $timestamp)) {
                    return $rule['event_group'];
                }
            }
        }

        return null;
    }
}
