<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    public function test_logout_requires_post_request(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('logout'))
            ->assertStatus(405);

        $this->assertAuthenticatedAs($user);
    }

    public function test_guest_cannot_logout(): void
    {
        $this->post(route('logout'))
            ->assertRedirect(route('login'));
    }
}
