<?php

use App\Livewire\Blogs\Blogs;
use App\Livewire\Blogs\Create;
use App\Livewire\Blogs\Edit;
use App\Livewire\Categories\Categories;
use App\Livewire\Categories\Create as CreateCategory;
use App\Livewire\Categories\Edit as EditCategory;
use App\Livewire\Roles\Roles;
use App\Livewire\Permissions\Permissions;
use App\Livewire\Users\Users;
use App\Livewire\Users\Edit as EditUser;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/roles', Roles::class)->name('roles.index');
    Route::get('/permissions', Permissions::class)->name('permissions.index');

    Route::middleware(['role:customer'])->group(function () {

        Route::prefix('customer')->group(function () {
            Route::view('/dashboard', 'dashboard')->name('dashboard');
        });

    });

    Route::middleware(['role:admin'])->group(function () {

        Route::prefix('admin')->group(function () {
            Route::view('/dashboard', 'admin')->name('admin');
            //Blogs
            Route::get('/blogs',Blogs::class)->name('blogs.index');
            Route::get('/blogs/create',Create::class)->name('blogs.create');
            Route::get('/blogs/{id}/edit',Edit::class)->name('blogs.edit');
            //Categories
            Route::get('/categories',Categories::class)->name('categories.index');
            Route::get('/categories/create',CreateCategory::class)->name('categories.create');
            Route::get('/categories/{id}/edit',EditCategory::class)->name('categories.edit');
            //Users
            Route::get('/users',Users::class)->name('users.index');
            Route::get('/users/{id}/edit',EditUser::class)->name('users.edit');
        });

    });

    Route::middleware(['role:vendor'])->group(function () {

        Route::prefix('vendor')->group(function () {
            Route::view('/dashboard', 'vendor')->name('vendor');
        });

    });

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

});

require __DIR__.'/auth.php';
