<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        Permission::firstOrCreate(['name' => 'view_users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'view_users_profiles', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'view_users_activity', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'add_users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'edit_users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'edit_own_account', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'delete_users', 'module' => 'Users']);

        $user = User::firstOrCreate(['email' => 'user@domain.com'], [
            'name'                 => 'Username',
            'email'                => 'user@domain.com',
            'password'             => bcrypt('password'),
            'is_active'            => 1,
            'is_office_login_only' => 0
        ]);
        
        //Some initially role configuration
        // $roles = [
        //     'Admin' => [
        //         'view posts',
        //         'create posts',
        //         'update posts',
        //         'delete posts',
        //     ],
        //     'Editor' => [
        //         'view posts',
        //         'create posts',
        //         'update posts'
        //     ],
        //     'Member' => [
        //         'view posts'
        //     ]
        // ];

        // collect($roles)->each(function ($permissions, $role) {
        //     $role = Role::findOrCreate($role);
        //     collect($permissions)->each(function ($permission) use ($role) {
        //         $role->permissions()->save(Permission::findOrCreate($permission));
        //     });
        // });
    }
}
