<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserDatabaseSeeder extends Seeder
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

        $owner = Role::firstOrCreate(['name' => 'owner', 'team_id' => null]);
        $superadmin = Role::firstOrCreate(['name' => 'superadmin', 'team_id' => 1]);
        $admin = Role::firstOrCreate(['name' => 'admin', 'team_id' => 1]);
        $manager = Role::firstOrCreate(['name' => 'manager', 'team_id' => 1]);
        $staff = Role::firstOrCreate(['name' => 'staff', 'team_id' => 1]);
        $userrole = Role::firstOrCreate(['name' => 'user', 'team_id' => 1]);

        $owner->givePermissionTo($permissions);
        $superadmin->givePermissionTo($permissions);
        $admin->givePermissionTo($permissions);
        $manager->givePermissionTo($permissions);
        $staff->givePermissionTo($permissions);
        $userrole->givePermissionTo($permissions);

        $staff->revokePermissionTo(['view_settings', 'add_settings', 'edit_settings', 'delete_settings', 'add_users', 'edit_users', 'delete_users']);
        $userrole->revokePermissionTo(['view_settings', 'add_settings', 'edit_settings', 'delete_settings', 'add_users', 'edit_users', 'delete_users']);

        $users = [
            'owner'      => 'owner@domain.com',
            'superadmin' => 'superadmin@domain.com',
            'admin'      => 'admin@domain.com',
            'manager'    => 'manager@domain.com',
            'staff'      => 'staff@domain.com',
            'user'       => 'user@domain.com',
        ];

        foreach ($users as $name => $email) {
            DB::transaction(function () use ($name, $email) {
                return tap(($name == 'owner' || $name == 'superadmin' || $name == 'admin') ? User::create([
                    'name'                 => $name,
                    'email'                => $email,
                    'password'             => Hash::make('secret'),
                    'is_office_login_only' => 0,
                    'admin'                => true
                ]) : User::create([
                    'name'                 => $name,
                    'email'                => $email,
                    'password'             => Hash::make('secret'),
                    'is_office_login_only' => 0,
                ]), function (User $user) {
                    $this->createTeam($user);
                });
            });
        }

        // Create one team
        $team = $this->createBigTeam('owner@domain.com');
        $user = Jetstream::findUserByEmailOrFail('owner@domain.com');

        foreach ($users as $name => $email) {
            if (!($name == 'owner' || $name == 'superadmin' || $name == 'admin')) {
                $team->users()->attach(
                    Jetstream::findUserByEmailOrFail($email),
                    ['role' => $name]
                );
            }
        }

        // get session team_id for restore it later
        $session_team_id = getPermissionsTeamId();
        // set actual new team_id to package instance
        setPermissionsTeamId($user);
        // get the admin user and assign roles/permissions on new team model
        $user->assignRole($owner);
        // restore session team_id to package instance
        setPermissionsTeamId($session_team_id);
    }

    /**
     * Create a personal team for the user.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id'       => $user->id,
            'name'          => 'Personal',
            'personal_team' => true,
        ]));
    }

    /**
     * @param mixed $email
     *
     * @return Team
     */
    protected function createBigTeam($email): Team
    {
        $user = Jetstream::findUserByEmailOrFail($email);
        $team = Team::forceCreate([
            'user_id'       => $user->id,
            'name'          => 'Big Company',
            'personal_team' => false,
        ]);
        $user->ownedTeams()->save($team);

        return $team;
    }
}
