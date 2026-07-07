<?php

namespace Database\Seeders\Support;

use Carbon\Carbon;

/**
 * Repassa, dentro do mesmo processo de `db:seed`, as publicações que
 * merecem uma galeria correspondente para GalleriesSeeder — a unica ponte
 * entre Publication e Gallery, ja que o schema nao tem FK entre as duas
 * (ver Category compartilhada). Estatica de proposito: nao ha necessidade
 * de persistir isso em disco, PublicationsSeeder e GalleriesSeeder rodam
 * na mesma execução do DatabaseSeeder.
 */
class LinkedGalleryRegistry
{
    /** @var array<int, array{title: string, category_ids: int[], date: Carbon, theme: string, event_group: ?string}> */
    private static array $entries = [];

    public static function register(string $title, array $categoryIds, Carbon $date, string $theme, ?string $eventGroup): void
    {
        self::$entries[] = [
            'title' => $title,
            'category_ids' => $categoryIds,
            'date' => $date,
            'theme' => $theme,
            'event_group' => $eventGroup,
        ];
    }

    /** @return array<int, array{title: string, category_ids: int[], date: Carbon, theme: string, event_group: ?string}> */
    public static function all(): array
    {
        return self::$entries;
    }

    public static function reset(): void
    {
        self::$entries = [];
    }
}
