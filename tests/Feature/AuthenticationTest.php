<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $this->seed(UserSeeder::class);

        $user = User::where('email', 'dylan@gmail.com')->first();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'samplepassword',
            'role' => 'User',
        ]);
        dump(DB::connection()->getDatabaseName());


        $this->assertAuthenticated();

        $dashboardResponse = $this->get(route('mapping', absolute: false));

        $dashboardResponse->assertOk();
        $dashboardResponse->assertSee('Customer Dashboard');
    }


    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
