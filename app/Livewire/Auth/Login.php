<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $query = DB::table('user_detail')
            ->join('users', 'users.user_detail_id', '=', 'user_detail.id')
            ->join('roles', 'roles.role_id', '=', 'user_detail.role_id')
            ->where('users.user_detail_id', auth()->user()->user_detail_id)
            ->select('users.name', 'roles.role_name')
            ->get();

        $user = $query->pluck('role_name');
        $roleName = $user->first();
        info($roleName);

        switch ($roleName) {
            case 'Admin':
                RateLimiter::clear($this->throttleKey());
                Session::regenerate();
                $this->redirectIntended(default: route('admin_dashboard', absolute: false), navigate: true);
            case 'User':
                RateLimiter::clear($this->throttleKey());
                Session::regenerate();
                $this->redirectIntended(default: route('customer_dashboard', absolute: false), navigate: true);
            case 'Worker':
                RateLimiter::clear($this->throttleKey());
                Session::regenerate();
                $this->redirectIntended(default: route('worker_dashboard', absolute: false), navigate: true);
        }
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
