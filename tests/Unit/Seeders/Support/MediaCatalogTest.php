<?php

namespace Tests\Unit\Seeders\Support;

use Database\Seeders\Support\MediaCatalog;
use PHPUnit\Framework\TestCase;

class MediaCatalogTest extends TestCase
{
    private string $fixtureDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixtureDir = sys_get_temp_dir().'/media_catalog_test_'.uniqid();
        mkdir($this->fixtureDir);
    }

    protected function tearDown(): void
    {
        array_map('unlink', glob($this->fixtureDir.'/*'));
        rmdir($this->fixtureDir);

        parent::tearDown();
    }

    private function touch(string $filename): void
    {
        file_put_contents($this->fixtureDir.'/'.$filename, str_repeat('x', random_int(1, 100)));
    }

    public function test_classifies_descriptive_filename_by_keyword(): void
    {
        $this->touch('Vacinação_drive-thru_atendimento_202607052010.jpeg');
        $catalog = new MediaCatalog($this->fixtureDir);

        $images = $catalog->imagesForTheme(MediaCatalog::THEME_VACINACAO, 5);

        $this->assertCount(1, $images);
        $this->assertStringContainsString('Vacinação_drive-thru', $images[0]);
    }

    public function test_keyword_matching_ignores_underscores_and_accents(): void
    {
        // "desfile_cívico" (chave) precisa bater com o nome normalizado
        // "desfile civico" (sem acento, com espaço) — regressão do bug
        // corrigido em MediaCatalog::normalize().
        $this->touch('Desfile_cívico_7_de_setembro_202607051951.jpeg');
        $catalog = new MediaCatalog($this->fixtureDir);

        $images = $catalog->imagesForTheme(MediaCatalog::THEME_CIVICO_ADMINISTRATIVO, 5);

        $this->assertCount(1, $images);
    }

    public function test_unclassified_filename_falls_back_to_eventos_diversos(): void
    {
        $this->touch('arquivo_sem_nenhuma_palavra_chave_reconhecida.jpeg');
        $catalog = new MediaCatalog($this->fixtureDir);

        $this->assertSame(
            [MediaCatalog::THEME_EVENTOS_DIVERSOS],
            $catalog->availableThemes()
        );
    }

    public function test_requesting_theme_with_empty_pool_falls_back_to_eventos_diversos(): void
    {
        $this->touch('generic_fallback_photo.jpeg');
        $catalog = new MediaCatalog($this->fixtureDir);

        $images = $catalog->imagesForTheme(MediaCatalog::THEME_VACINACAO, 3);

        $this->assertCount(1, $images);
    }

    public function test_exact_duplicate_files_are_deduplicated_by_content_hash(): void
    {
        file_put_contents($this->fixtureDir.'/Torneio_municipal_de_Goalball_a.jpeg', 'same-bytes');
        file_put_contents($this->fixtureDir.'/Torneio_municipal_de_Goalball_b.jpeg', 'same-bytes');
        $catalog = new MediaCatalog($this->fixtureDir);

        $images = $catalog->imagesForTheme(MediaCatalog::THEME_ESPORTE, 5);

        $this->assertCount(1, $images);
    }

    public function test_generic_batch_rule_by_filename_prefix_and_timestamp(): void
    {
        $this->touch('Realistic_photos_Brazilian_munic…_202607052042 (3).jpeg');
        $catalog = new MediaCatalog($this->fixtureDir);

        $images = $catalog->imagesForTheme(MediaCatalog::THEME_SAO_JOAO, 5);

        $this->assertCount(1, $images);
    }

    public function test_event_groups_cluster_generic_batch_files_together(): void
    {
        $this->touch('Realistic_photos_Brazilian_munic…_202607052041.jpeg');
        $this->touch('Realistic_photos_Brazilian_munic…_202607052042 (1).jpeg');
        $catalog = new MediaCatalog($this->fixtureDir);

        $groups = $catalog->eventGroups();

        $this->assertTrue($groups->has('sao_joao_noite_praca'));
        $this->assertCount(2, $groups->get('sao_joao_noite_praca'));
    }

    public function test_missing_directory_yields_no_themes(): void
    {
        $catalog = new MediaCatalog($this->fixtureDir.'/does-not-exist');

        $this->assertSame([], $catalog->availableThemes());
        $this->assertSame([], $catalog->imagesForTheme(MediaCatalog::THEME_SAUDE, 3));
    }
}
