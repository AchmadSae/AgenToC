<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Helpers\GenerateId;
use App\Models\UserDetailModel;
use App\Models\RoleModel;
use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {

        /**
         * begin assign data to create new users by role
         **/
        $validatedForUsersTable = $this->validate([
            'role' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'skill' => ['string', 'max:255'],
            'tagline' => ['string', 'max:255'],
        ]);
        event(new Registered(($user = User::create($validatedForUsersTable))));
        Auth::login($user);

        $this->redirect(route('login', absolute: false), navigate: true);
        /**
         * end assign data to create new users by role
         **/

    }



}

