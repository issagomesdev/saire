<?php

namespace Tests\Unit\Models;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Tests\TestCase;

class PublicationTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['title', 'text', 'status', 'created_at', 'updated_at', 'deleted_at'],
            (new Publication)->getFillable()
        );
    }

    public function test_implements_has_media(): void
    {
        $this->assertInstanceOf(HasMedia::class, new Publication);
    }

    public function test_categories_relationship(): void
    {
        $this->assertInstanceOf(BelongsToMany::class, (new Publication)->categories());
    }

    public function test_serializes_dates_as_y_m_d_h_i_s(): void
    {
        $publication = new Publication(['created_at' => '2024-06-15 10:30:00']);

        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/',
            $publication->toArray()['created_at']
        );
    }
}
