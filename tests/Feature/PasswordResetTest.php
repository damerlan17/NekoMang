<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_is_available(): void
    {
        $this->get(route('password.request'))
            ->assertOk();
    }

    public function test_password_reset_notification_is_sent(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), [
            'email' => $user->email,
        ])->assertSessionHasNoErrors();

        Notification::assertSentTo(
            $user,
            ResetPassword::class
        );
    }

    public function test_password_can_be_reset(): void
    {
        $user = User::factory()->create([
            'password' => 'OldPassword123!',
        ]);

        $token = Password::createToken($user);

        $this->get(route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]))->assertOk();

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ])->assertRedirect(route('login'));

        $user->refresh();

        $this->assertTrue(
            Hash::check('NewPassword123!', $user->password)
        );

        $this->assertFalse(
            Hash::check('OldPassword123!', $user->password)
        );

        $this->assertSame('reader', $user->role->slug);

        $this->assertDatabaseMissing(
            'password_reset_tokens',
            ['email' => $user->email]
        );
    }

    public function test_invalid_token_is_rejected(): void
    {
        $user = User::factory()->create([
            'password' => 'OldPassword123!',
        ]);

        $this->post(route('password.update'), [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ])->assertSessionHasErrors('email');

        $this->assertTrue(
            Hash::check(
                'OldPassword123!',
                $user->fresh()->password
            )
        );
    }

    public function test_reset_token_cannot_be_used_twice(): void
    {
        $user = User::factory()->create();

        $token = Password::createToken($user);

        $data = [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ];

        $this->post(
            route('password.update'),
            $data
        )->assertRedirect(route('login'));

        $this->post(
            route('password.update'),
            $data
        )->assertSessionHasErrors('email');
    }

    public function test_unknown_email_does_not_reveal_account_existence(): void
    {
        Notification::fake();

        $this->post(route('password.email'), [
            'email' => 'unknown@example.com',
        ])->assertSessionHasNoErrors();

        Notification::assertNothingSent();
    }
}
