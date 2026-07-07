<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class RoleTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['title', 'lab', 'created_at', 'updated_at', 'deleted_at'],
            (new Role)->getFillable()
        );
    }

    public function test_permissions_relationship(): void
    {
        $this->assertInstanceOf(BelongsToMany::class, (new Role)->permissions());
    }
}
