<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserDatabaseSeederTest extends Seeder
{
    public function run()
    {
        Model::unguard();

        Permission::firstOrCreate(['name' => 'view_users', 'module' => 'User']);
        Permission::firstOrCreate(['name' => 'view_users_profiles', 'module' => 'User']);
        Permission::firstOrCreate(['name' => 'view_users_activity', 'module' => 'User']);
        Permission::firstOrCreate(['name' => 'add_users', 'module' => 'User']);
        Permission::firstOrCreate(['name' => 'edit_users', 'module' => 'User']);
        Permission::firstOrCreate(['name' => 'edit_own_account', 'module' => 'User']);
        Permission::firstOrCreate(['name' => 'delete_users', 'module' => 'User']);

        $permissions = Permission::all();

        $superadmin = Role::firstOrCreate(['name' => 'superadmin', 'team_id' => null]);
        $admin = Role::firstOrCreate(['name' => 'admin', 'team_id' => 1]);
        $userrole = Role::firstOrCreate(['name' => 'user', 'team_id' => 1]);

        $superadmin->givePermissionTo($permissions);
        $admin->givePermissionTo($permissions);
        $userrole->givePermissionTo($permissions);

        $userrole->revokePermissionTo(['add_users', 'edit_users', 'delete_users']);

        $user = (new CreateNewUser())->create([
            'name'                 => 'Lara_lab',
            'email'                => 'user@domain.com',
            'password'             => 'password',
            'password_confirmation'=> 'password',
            'email_verified_at'    => session('teamInvitation') ? now() : null,
            'is_active'            => 1,
            'is_office_login_only' => 0,
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
