<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Rules\Recaptcha;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Recaptcha Token
     */
    public $recaptcha_token;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'recaptcha_token' => ['required', new Recaptcha]
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        // Assign default Role to the new user
        $user->assignRole('User');
        // Auto Login User
        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header title="Create an account" description="Enter your details below to create your account" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="register" class="flex flex-col gap-6" x-data="{ siteKey: @js(config('services.recaptcha.public_key')), token: '' }" x-init="grecaptcha.ready(() => {
            $el.addEventListener('submit', (e) => {
                e.preventDefault();
                grecaptcha.execute(siteKey, { action: 'register' }).then(t => {
                    token = t;
                    $wire.recaptcha_token = t;
                    $wire.register(); // trigger Livewire after token is set
                });
            });
        })">
        <!-- Name -->
        <flux:input
            wire:model="name"
            id="name"
            :label="__('Name')"
            type="text"
            name="name"
            required
            autofocus
            autocomplete="name"
            placeholder="Full name"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            id="email"
            :label="__('Email address')"
            type="email"
            name="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            id="password"
            :label="__('Password')"
            type="password"
            name="password"
            required
            autocomplete="new-password"
            placeholder="Password"
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            id="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            name="password_confirmation"
            required
            autocomplete="new-password"
            placeholder="Confirm password"
        />

        <!-- Recaptcha Field -->
        <input type="hidden" x-model="token" x-effect="$wire.recaptcha_token = token">

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        Already have an account?
        <flux:link :href="route('login')" wire:navigate>Log in</flux:link>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.public_key') }}"></script>
