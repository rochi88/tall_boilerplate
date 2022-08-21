<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\Setting;

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
    }
}