<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Assert;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        if (!Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_registration_screen_cannot_be_rendered_if_support_is_disabled(): void
    {
        if (Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration support is enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    public function test_new_users_can_register(): void
    {
        if (!Features::enabled(Features::registration())) {
            info('Registration support is not enabled.');
            $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'Worker',
            'tagline' => 'Show Your Tag Line',
            'skills' => 'Graphic Designer',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);
        dump($response);
        Assert::assertTrue(User::where('email', 'test@example.com')->exists());
    }
}
