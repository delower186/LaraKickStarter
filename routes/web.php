<?php

use App\Livewire\Blogs\Blogs;
use App\Livewire\Blogs\Create;
use App\Livewire\Blogs\Edit;
use App\Livewire\Categories\Categories;
use App\Livewire\Categories\Create as CreateCategory;
use App\Livewire\Categories\Edit as EditCategory;
use App\Livewire\Configuraton\Configuration;
use App\Livewire\Roles\Roles;
use App\Livewire\Roles\Create as CreateRole;
use App\Livewire\Roles\Edit as EditRole;
use App\Livewire\Permissions\Permissions;
use App\Livewire\Permissions\Create as CreatePermission;
use App\Livewire\Permissions\Edit as EditPermission;
use App\Livewire\Users\Users;
use App\Livewire\Users\Edit as EditUser;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\Dashboard\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->group(function () {
        // Roles
        Route::get('/roles', Roles::class)->name('roles.list');
        Route::get('/roles/create',CreateRole::class)->name('roles.create');
        Route::get('/roles/{id}/edit',EditRole::class)->name('roles.edit');
        // Permissions
        Route::get('/permissions', Permissions::class)->name('permissions.list');
        Route::get('/permissions/create',CreatePermission::class)->name('permissions.create');
        Route::get('/permissions/{id}/edit',EditPermission::class)->name('permissions.edit');
        // Blogs
        Route::get('/blogs',Blogs::class)->name('blogs.list');
        Route::get('/blogs/create',Create::class)->name('blogs.create');
        Route::get('/blogs/{id}/edit',Edit::class)->name('blogs.edit');
        // Categories
        Route::get('/categories',Categories::class)->name('categories.list');
        Route::get('/categories/create',CreateCategory::class)->name('categories.create');
        Route::get('/categories/{id}/edit',EditCategory::class)->name('categories.edit');
        // Users
        Route::get('/users',Users::class)->name('users.list');
        Route::get('/users/{id}/edit',EditUser::class)->name('users.edit');
        // Configuration
        Route::get('/configuration',Configuration::class)->name('configuration');
    });

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

});

require __DIR__.'/auth.php';
