<?php

namespace Tests\Unit\Models;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['title', 'description', 'created_at', 'updated_at', 'deleted_at'],
            (new Gallery)->getFillable()
        );
    }

    public function test_implements_has_media(): void
    {
        $this->assertInstanceOf(HasMedia::class, new Gallery);
    }

    public function test_categories_relationship(): void
    {
        $this->assertInstanceOf(BelongsToMany::class, (new Gallery)->categories());
    }

    public function test_serializes_dates_as_y_m_d_h_i_s(): void
    {
        $gallery = new Gallery(['created_at' => '2024-06-15 10:30:00']);

        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/',
            $gallery->toArray()['created_at']
        );
    }
}
