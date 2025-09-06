<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use App\Rules\Recaptcha;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Recaptcha Token
     */
    #[Validate(['recaptcha_token' => ['required', new Recaptcha]])]
    public $recaptcha_token;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {

        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        /*
         *
         * Redirect based on user role
         *
         * by Delower
         *
         */
        if (!Auth::user()->status > 0){

            LivewireAlert::title('Error')
            ->text('Your Account is Inactive, Please contact support...')
            ->error()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

            Auth::logout();

        }else{
            RateLimiter::clear($this->throttleKey());
            Session::regenerate();

            LivewireAlert::title('Success')
            ->text('Login Successfull! Redirecting to Dashboard...')
            ->success()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();

            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }

    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
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
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header title="Log in to your account" description="Enter your email and password below to log in" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="login" class="flex flex-col gap-6" x-data="{ siteKey: @js(config('services.recaptcha.public_key')), token: '' }" x-init="grecaptcha.ready(() => {
            $el.addEventListener('submit', (e) => {
                e.preventDefault();
                grecaptcha.execute(siteKey, { action: 'login' }).then(t => {
                    token = t;
                    $wire.recaptcha_token = t;
                    $wire.login(); // trigger Livewire after token is set
                });
            });
        })">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            name="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Password"
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute right-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Recaptcha Field -->
        <input type="hidden" x-model="token" x-effect="$wire.recaptcha_token = token">

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>
    </form>

    @if (Route::has('register'))
      <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
          Don't have an account?
          <flux:link :href="route('register')" wire:navigate>Sign up</flux:link>
      </div>
    @endif
</div>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.public_key') }}"></script>
