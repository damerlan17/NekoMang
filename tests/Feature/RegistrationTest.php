<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function registrationData(): array
    {
        return [
            'name' => 'NewReader',
            'email' => 'newreader@example.com',
            'password' => 'TestPassword123!',
            'password_confirmation' => 'TestPassword123!',
            'terms' => '1',
        ];
    }

    public function test_registration_page_is_available(): void
    {
        $this->get(route('register'))
            ->assertOk();
    }

    public function test_user_can_register(): void
    {
        $response = $this->post(
            route('register.store'),
            $this->registrationData()
        );

        $response->assertSessionHasNoErrors();

        $user = User::where(
            'email',
            'newreader@example.com'
        )->firstOrFail();

        $this->assertSame('NewReader', $user->name);
        $this->assertSame('reader', $user->role->slug);

        $this->assertTrue(
            Hash::check('TestPassword123!', $user->password)
        );

        $this->assertNotSame(
            'TestPassword123!',
            $user->password
        );
    }

    public function test_duplicate_email_is_rejected(): void
    {
        User::factory()->create([
            'email' => 'newreader@example.com',
        ]);

        $this->post(
            route('register.store'),
            $this->registrationData()
        )->assertSessionHasErrors('email');

        $this->assertSame(
            1,
            User::where(
                'email',
                'newreader@example.com'
            )->count()
        );
    }

    public function test_duplicate_name_is_rejected(): void
    {
        User::factory()->create([
            'name' => 'NewReader',
        ]);

        $this->post(
            route('register.store'),
            $this->registrationData()
        )->assertSessionHasErrors('name');
    }

    public function test_short_password_is_rejected(): void
    {
        $data = $this->registrationData();

        $data['password'] = '123';
        $data['password_confirmation'] = '123';

        $this->post(
            route('register.store'),
            $data
        )->assertSessionHasErrors('password');
    }

    public function test_password_confirmation_is_required(): void
    {
        $data = $this->registrationData();

        $data['password_confirmation'] = 'WrongPassword';

        $this->post(
            route('register.store'),
            $data
        )->assertSessionHasErrors('password');
    }

    public function test_terms_must_be_accepted(): void
    {
        $data = $this->registrationData();

        unset($data['terms']);

        $this->post(
            route('register.store'),
            $data
        )->assertSessionHasErrors('terms');
    }

    public function test_invalid_email_is_rejected(): void
    {
        $data = $this->registrationData();

        $data['email'] = 'invalid-email';

        $this->post(
            route('register.store'),
            $data
        )->assertSessionHasErrors('email');
    }

    public function test_user_cannot_register_as_admin(): void
    {
        $data = $this->registrationData();

        $data['role_id'] = Role::where(
            'slug',
            'admin'
        )->firstOrFail()->id;

        $this->post(
            route('register.store'),
            $data
        )->assertSessionHasNoErrors();

        $user = User::where(
            'email',
            'newreader@example.com'
        )->firstOrFail();

        $this->assertSame('reader', $user->role->slug);
    }
}
