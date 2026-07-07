<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['title', 'description', 'created_at', 'updated_at', 'deleted_at'],
            (new Category)->getFillable()
        );
    }

    public function test_serializes_dates_as_y_m_d_h_i_s(): void
    {
        $category = new Category(['created_at' => '2024-06-15 10:30:00']);

        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/',
            $category->toArray()['created_at']
        );
    }
}
