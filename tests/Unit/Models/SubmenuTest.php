<?php

namespace Tests\Unit\Models;

use App\Models\Submenu;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class SubmenuTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['title', 'position', 'link_type', 'page_id', 'url', 'created_at', 'updated_at', 'deleted_at'],
            (new Submenu)->getFillable()
        );
    }

    public function test_page_relationship(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Submenu)->page());
    }

    public function test_link_type_options(): void
    {
        $this->assertSame([
            '0' => 'Página Interna',
            '1' => 'Página Externa',
        ], Submenu::LINK_TYPE_RADIO);
    }
}
