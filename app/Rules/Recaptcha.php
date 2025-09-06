<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(), // Optional: for improved security
        ])->json();


        if(!$response['success']) {
            LivewireAlert::title('Error')
            ->text('reCAPTCHA verification failed. Please try again...')
            ->error()
            ->toast()
            ->position('top-end')
            ->timer(3000) // Dismisses after 3 seconds
            ->show();
        }

    }
}
