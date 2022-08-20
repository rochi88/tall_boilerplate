<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CorePermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'view_dashboard', 'module' => 'Core']);
        Permission::firstOrCreate(['name' => 'view_search', 'module' => 'Core']);

        Permission::firstOrCreate(['name' => 'view_settings', 'module' => 'Core']);
        Permission::firstOrCreate(['name' => 'add_settings', 'module' => 'Core']);
        Permission::firstOrCreate(['name' => 'edit_settings', 'module' => 'Core']);
        Permission::firstOrCreate(['name' => 'delete_settings', 'module' => 'Core']);
    }
}
