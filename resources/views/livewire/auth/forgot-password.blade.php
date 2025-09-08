<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Rules\Recaptcha;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Recaptcha Token
     */
    public $recaptcha_token;

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
            'recaptcha_token' => ['required', new Recaptcha]
        ]);

        Password::sendResetLink($this->only('email'));

        LivewireAlert::title('Success')
        ->text('A reset link will be sent if the account exists.')
        ->success()
        ->toast()
        ->position('top-end')
        ->timer(3000) // Dismisses after 3 seconds
        ->show();

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header title="Forgot password" description="Enter your email to receive a password reset link" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="sendPasswordResetLink" class="flex flex-col gap-6" x-data="{ siteKey: @js(config('services.recaptcha.public_key')), token: '' }" x-init="grecaptcha.ready(() => {
            $el.addEventListener('submit', (e) => {
                e.preventDefault();
                grecaptcha.execute(siteKey, { action: 'sendPasswordResetLink' }).then(t => {
                    token = t;
                    $wire.recaptcha_token = t;
                    $wire.sendPasswordResetLink(); // trigger Livewire after token is set
                });
            });
        })">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email Address')"
            type="email"
            name="email"
            required
            autofocus
            placeholder="email@example.com"
        />

        <!-- Recaptcha Field -->
        <input type="hidden" x-model="token" x-effect="$wire.recaptcha_token = token">

        <flux:button variant="primary" type="submit" class="w-full">{{ __('Email password reset link') }}</flux:button>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-400">
        Or, return to
        <flux:link :href="route('login')" wire:navigate>log in</flux:link>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.public_key') }}"></script>
