<?php

namespace Tests\Unit\Models;

use App\Models\Page;
use Spatie\MediaLibrary\HasMedia;
use Tests\TestCase;

class PageTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['title', 'content', 'created_at', 'updated_at', 'deleted_at'],
            (new Page)->getFillable()
        );
    }

    public function test_implements_has_media(): void
    {
        $this->assertInstanceOf(HasMedia::class, new Page);
    }
}
