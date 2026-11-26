<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_available(): void
    {
        $this->get(route('login'))
            ->assertOk();
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'password' => 'TestPassword123!',
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'TestPassword123!',
        ])->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_password_is_rejected(): void
    {
        $user = User::factory()->create([
            'password' => 'TestPassword123!',
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'WrongPassword123!',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_unknown_user_cannot_login(): void
    {
        $this->post(route('login.store'), [
            'email' => 'unknown@example.com',
            'password' => 'TestPassword123!',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_empty_login_form_is_rejected(): void
    {
        $this->post(route('login.store'), [
            'email' => '',
            'password' => '',
        ])->assertSessionHasErrors([
            'email',
            'password',
        ]);

        $this->assertGuest();
    }
}
