<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Configuration;
use App\Models\Category;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    /**
     * Seed the application's database.
     */
    
    public function run(): void
    {
        /**
         * @var mixed
         * Role Seeder
         */

        $roles = ['Super Admin', 'Admin', 'User'];

        foreach ($roles as $key => $value) {
            Role::create(['name' => $value]);
        }

        /***
         * Create User and assign role
         */

        $super = User::create([
            'name' => 'Super Admin',
            'email' => 'super@super.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'status' => '1',
            'remember_token' => Str::random(10),
        ]);

        $super->assignRole('Super Admin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'status' => '1',
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole('Admin');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'status' => '1',
            'remember_token' => Str::random(10),
        ]);

        $user->assignRole('User');

        /***
         * Permission Seeder
         */

        $permissions = [
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
            'product.view',
            'product.create',
            'product.edit',
            'product.delete',
            'blog.view',
            'blog.create',
            'blog.edit',
            'blog.delete',
            'category.view',
            'category.create',
            'category.edit',
            'category.delete',
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',
            'configuration.view',
            'configuration.edit'
        ];

        foreach ($permissions as $key => $value) {
            Permission::create(['name'=> $value]);
        }

        $role = Role::findByName('Admin');
        $role->givePermissionTo([
            'product.view',
            'product.create',
            'product.edit',
            'product.delete',
            'blog.view',
            'blog.create',
            'blog.edit',
            'blog.delete',
            'category.view',
            'category.create',
            'category.edit',
            'category.delete',
        ]);

        $role = Role::findByName('User');
        $role->givePermissionTo(['product.view','blog.view']);

        // Category::factory()->count(15)->create();
        // Blog::factory()->count(25)->create();

        Configuration::create([
            'site_name' => 'LaraKickStarter',
            'logo' => 'images/logo/logo.png',
            'favicon' => 'favicon.ico',
        ]);


    }
}
