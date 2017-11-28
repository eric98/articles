<?php

use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (!function_exists('assignPermission')) {
    function assignPermission($role, $permission) {
        if (! $role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }
    }
}

if (!function_exists('initialize_articles_permissions')) {
    function initialize_articles_permissions()
    {
        Permission::firstOrCreate(['name' => 'list-articles']);
        Permission::firstOrCreate(['name' => 'show-article']);
        Permission::firstOrCreate(['name' => 'store-article']);
        Permission::firstOrCreate(['name' => 'update-article']);
        Permission::firstOrCreate(['name' => 'destroy-article']);

        $role = Role::firstOrCreate(['name' => 'articles-manager']);

        assignPermission($role,'list-articles');
        assignPermission($role,'show-article');
        assignPermission($role,'store-article');
        assignPermission($role,'update-article');
        assignPermission($role,'destroy-article');


        Permission::firstOrCreate(['name' => 'list-users']);
        Permission::firstOrCreate(['name' => 'show-user']);
        Permission::firstOrCreate(['name' => 'store-user']);
        Permission::firstOrCreate(['name' => 'update-user']);
        Permission::firstOrCreate(['name' => 'destroy-user']);

        $role = Role::firstOrCreate(['name' => 'users-manager']);

        assignPermission($role,'list-users');
        assignPermission($role,'show-user');
        assignPermission($role,'store-user');
        assignPermission($role,'update-user');
        assignPermission($role,'destroy-user');
    }
}

if (!function_exists('create_admin_user')) {
    function create_admin_user()
    {
        factory(User::class)->create([
            'name'     => env('ARTICLES_USER_NAME', 'Eric Garcia Reverter'),
            'email'    => env('ARTICLES_USER_EMAIL', 'ergare.17@gmail.com'),
            'password' => bcrypt(env('ARTICLES_USER_PASSWORD')),
        ]);
    }
}

if (!function_exists('first_user_as_articles_manager')) {
    function first_user_as_articles_manager()
    {
        User::all()->first()->assignRole('articles-manager');
        User::all()->first()->assignRole('users-manager');
    }
}
