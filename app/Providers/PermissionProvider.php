<?php

namespace App\Providers;

use App\Tools\Permission;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class PermissionProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('permission', new Permission());
    }
}
