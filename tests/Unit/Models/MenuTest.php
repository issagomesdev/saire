<?php

namespace Tests\Unit\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class MenuTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['title', 'position', 'link_type', 'page_id', 'url', 'created_at', 'updated_at', 'deleted_at'],
            (new Menu)->getFillable()
        );
    }

    public function test_submenuses_relationship(): void
    {
        $this->assertInstanceOf(BelongsToMany::class, (new Menu)->submenuses());
    }

    public function test_page_relationship(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Menu)->page());
    }

    public function test_link_type_options(): void
    {
        $this->assertSame([
            '0' => 'SubMenus',
            '1' => 'Página Interna',
            '2' => 'Página Externa',
        ], Menu::LINK_TYPE_RADIO);
    }
}
