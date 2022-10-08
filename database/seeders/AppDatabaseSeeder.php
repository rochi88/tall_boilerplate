<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AppDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        Setting::firstOrCreate(['key' => 'app.name'], ['value' => 'Lara_lab']);
        Setting::firstOrCreate(['key' => 'applicationLogo'], ['value' => 'logo/A9dQcvFuzYLCVUfzrwqnSxN6RLKuCNDhjHwEVN3t.png']);
        Setting::firstOrCreate(['key' => 'applicationLogoDark'], ['value' => 'logo/A9dQcvFuzYLCVUfzrwqnSxN6RLKuCNDhjHwEVN3t.png']);
        Setting::firstOrCreate(['key' => 'loginLogo'], ['value' => 'logo/xbC28LrLRPgFQs3D4QEdTHnaJbGbT1QuCxnoxAAu.png']);
        Setting::firstOrCreate(['key' => 'loginLogoDark'], ['value' => 'logo/xbC28LrLRPgFQs3D4QEdTHnaJbGbT1QuCxnoxAAu.png']);
        Setting::firstOrCreate(['key' => 'ips'], ['value' => '[{"ip":"192.168.2.3","comment":"local"}]']);
        Setting::firstOrCreate(['key' => 'forced_2fa'], ['value' => '']);

        Permission::firstOrCreate(['name' => 'view_dashboard', 'module' => 'Core']);
        Permission::firstOrCreate(['name' => 'view_search', 'module' => 'Core']);
        Permission::firstOrCreate(['name' => 'view_settings', 'module' => 'Core']);
        Permission::firstOrCreate(['name' => 'add_settings', 'module' => 'Core']);
        Permission::firstOrCreate(['name' => 'edit_settings', 'module' => 'Core']);
        Permission::firstOrCreate(['name' => 'delete_settings', 'module' => 'Core']);
    }
}
