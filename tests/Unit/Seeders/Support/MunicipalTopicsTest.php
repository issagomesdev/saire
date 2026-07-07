<?php

namespace Tests\Unit\Seeders\Support;

use Database\Seeders\Support\MediaCatalog;
use Database\Seeders\Support\MunicipalTopics;
use PHPUnit\Framework\TestCase;

class MunicipalTopicsTest extends TestCase
{
    public function test_catalog_is_not_empty(): void
    {
        $this->assertNotEmpty(MunicipalTopics::all());
    }

    /**
     * @dataProvider topicKeyProvider
     */
    public function test_every_topic_has_the_required_shape(string $key, array $topic): void
    {
        $this->assertArrayHasKey('categories', $topic, "topic '{$key}' missing 'categories'");
        $this->assertNotEmpty($topic['categories'], "topic '{$key}' has empty 'categories'");

        $this->assertArrayHasKey('titles', $topic, "topic '{$key}' missing 'titles'");
        $this->assertNotEmpty($topic['titles'], "topic '{$key}' has empty 'titles'");

        $this->assertArrayHasKey('intro_templates', $topic, "topic '{$key}' missing 'intro_templates'");
        $this->assertNotEmpty($topic['intro_templates'], "topic '{$key}' has empty 'intro_templates'");

        $this->assertArrayHasKey('facts', $topic, "topic '{$key}' missing 'facts'");
        $this->assertNotEmpty($topic['facts'], "topic '{$key}' has empty 'facts'");

        $this->assertArrayHasKey('media_theme', $topic, "topic '{$key}' missing 'media_theme'");
        $this->assertContains(
            $topic['media_theme'],
            $this->validThemeConstants(),
            "topic '{$key}' has an unknown media_theme: {$topic['media_theme']}"
        );
    }

    public function test_topic_keys_are_unique(): void
    {
        $keys = array_map(fn (array $topic) => $topic['key'], MunicipalTopics::all());

        $this->assertSame($keys, array_unique($keys));
    }

    public static function topicKeyProvider(): array
    {
        $cases = [];
        foreach (MunicipalTopics::all() as $topic) {
            $cases[$topic['key']] = [$topic['key'], $topic];
        }

        return $cases;
    }

    private function validThemeConstants(): array
    {
        $reflection = new \ReflectionClass(MediaCatalog::class);

        return array_values($reflection->getConstants());
    }
}
