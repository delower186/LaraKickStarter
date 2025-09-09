<?php

namespace App\Providers;

use App\Tools\Helpers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Change Site Name dynamically
        if (\Schema::hasTable('configurations')) { // check if table exists (avoid migration errors)
            $site_name = Helpers::getValue('site_name', config('app.name'));
            config(['app.name' => $site_name]);
        }
    }
}
