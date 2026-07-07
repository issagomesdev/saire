<?php

namespace Tests\Feature\System;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_the_admin_panel(): void
    {
        $this->get(route('admin.home'))->assertRedirect(route('login'));
    }

    public function test_login_with_valid_credentials_authenticates_the_user(): void
    {
        $user = User::factory()->create(['password' => 'senha-correta']);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'senha-correta',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_invalid_credentials_is_rejected(): void
    {
        $user = User::factory()->create(['password' => 'senha-correta']);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'senha-errada',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_logout_ends_the_session(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('logout'))->assertRedirect();

        $this->assertGuest();
    }
}
