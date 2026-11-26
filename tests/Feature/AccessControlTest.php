<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithRole(string $slug): User
    {
        $role = Role::where('slug', $slug)
            ->firstOrFail();

        return User::factory()->create([
            'role_id' => $role->id,
        ]);
    }

    public function test_guest_can_access_home(): void
    {
        $this->get(route('home'))
            ->assertOk();
    }

    public function test_guest_cannot_access_profile(): void
    {
        $this->get(route('profile.index'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_admin_panel(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_reader_can_access_profile(): void
    {
        $reader = $this->createUserWithRole('reader');

        $this->actingAs($reader)
            ->get(route('profile.index'))
            ->assertOk();
    }

    public function test_reader_cannot_access_admin_panel(): void
    {
        $reader = $this->createUserWithRole('reader');

        $this->actingAs($reader)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_panel(): void
    {
        $admin = $this->createUserWithRole('admin');

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_admin_can_access_profile(): void
    {
        $admin = $this->createUserWithRole('admin');

        $this->actingAs($admin)
            ->get(route('profile.index'))
            ->assertOk();
    }

    public function test_authenticated_user_cannot_open_login(): void
    {
        $reader = $this->createUserWithRole('reader');

        $this->actingAs($reader)
            ->get(route('login'))
            ->assertRedirect(route('home'));
    }

    public function test_authenticated_user_cannot_open_registration(): void
    {
        $reader = $this->createUserWithRole('reader');

        $this->actingAs($reader)
            ->get(route('register'))
            ->assertRedirect(route('home'));
    }
}
