<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $this->assertEqualsCanonicalizing(
            ['name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'],
            (new User)->getFillable()
        );
    }

    public function test_password_and_remember_token_are_hidden(): void
    {
        $this->assertEqualsCanonicalizing(['remember_token', 'password'], (new User)->getHidden());
    }

    public function test_roles_relationship(): void
    {
        $this->assertInstanceOf(BelongsToMany::class, (new User)->roles());
    }

    public function test_password_is_hashed_on_assignment(): void
    {
        $user = new User(['password' => 'plain-text-password']);

        $this->assertNotSame('plain-text-password', $user->password);
        $this->assertTrue(app('hash')->check('plain-text-password', $user->password));
    }

    public function test_password_already_hashed_is_not_rehashed(): void
    {
        $hashed = app('hash')->make('plain-text-password');
        $user = new User(['password' => $hashed]);

        $this->assertSame($hashed, $user->password);
    }
}
