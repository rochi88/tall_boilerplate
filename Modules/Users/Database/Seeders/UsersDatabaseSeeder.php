<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Actions\Fortify\CreateNewUser;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call([
            UsersPermissionSeeder::class
        ]);

        $superadmin = Role::firstOrCreate(['name' => 'superadmin','team_id' => null]);
        $admin = Role::firstOrCreate(['name' => 'admin','team_id' => 1]);
        $userrole = Role::firstOrCreate(['name' => 'user','team_id' => 1]);

        $permissions = Permission::all();

        $superadmin->givePermissionTo($permissions);
        $admin->givePermissionTo($permissions);
        $userrole->givePermissionTo($permissions);

        $userrole->revokePermissionTo(['add_users', 'edit_users', 'delete_users']);

        $user = (new CreateNewUser())->create([
            'name'                 => 'Lara',
            'email'                => 'user@domain.com',
            'password'             => 'password',
            'password_confirmation'=> 'password',
            'email_verified_at'    => session('teamInvitation') ? now() : null,
            'is_active'            => 1,
            'is_office_login_only' => 0
        ]);

         // get session team_id for restore it later
         $session_team_id = getPermissionsTeamId();
         // set actual new team_id to package instance
         setPermissionsTeamId($user);
         // get the admin user and assign roles/permissions on new team model
         $user->assignRole($superadmin);
         // restore session team_id to package instance
         setPermissionsTeamId($session_team_id);
    }
}