<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UsersPermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'view_users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'view_users_profiles', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'view_users_activity', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'add_users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'edit_users', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'edit_own_account', 'module' => 'Users']);
        Permission::firstOrCreate(['name' => 'delete_users', 'module' => 'Users']);
    }
}
