<?php

namespace Tests\Unit\Models;

use App\Models\Permission;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['title', 'lab', 'created_at', 'updated_at', 'deleted_at'],
            (new Permission)->getFillable()
        );
    }
}
