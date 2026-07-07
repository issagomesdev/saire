<?php

namespace Tests\Unit\Models;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['description', 'subject_id', 'subject_type', 'user_id', 'properties', 'host'],
            (new AuditLog)->getFillable()
        );
    }

    public function test_user_relationship(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new AuditLog)->user());
    }

    public function test_properties_is_cast_to_collection(): void
    {
        $log = new AuditLog(['properties' => ['title' => 'Exemplo']]);

        $this->assertInstanceOf(Collection::class, $log->properties);
        $this->assertSame('Exemplo', $log->properties->get('title'));
    }
}
