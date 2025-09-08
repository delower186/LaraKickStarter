<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Rules\Recaptcha;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $password = '';

    /**
     * Recaptcha Token
     */
    public $recaptcha_token;

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
            'recaptcha_token' => ['required', new Recaptcha]
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        LivewireAlert::title('Success')
        ->text('Password confirmed at '.time())
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header
        title="Confirm password"
        description="This is a secure area of the application. Please confirm your password before continuing."
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="confirmPassword" class="flex flex-col gap-6" x-data="{ siteKey: @js(config('services.recaptcha.public_key')), token: '' }" x-init="grecaptcha.ready(() => {
            $el.addEventListener('submit', (e) => {
                e.preventDefault();
                grecaptcha.execute(siteKey, { action: 'confirmPassword' }).then(t => {
                    token = t;
                    $wire.recaptcha_token = t;
                    $wire.confirmPassword(); // trigger Livewire after token is set
                });
            });
        })">
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

        <!-- Recaptcha Field -->
        <input type="hidden" x-model="token" x-effect="$wire.recaptcha_token = token">

        <flux:button variant="primary" type="submit" class="w-full">{{ __('Confirm') }}</flux:button>
    </form>
</div>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.public_key') }}"></script>
