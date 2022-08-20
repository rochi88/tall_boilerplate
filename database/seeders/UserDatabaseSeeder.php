<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;

class UserDatabaseSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $user = User::create([
            'name'                 => 'Lara',
            'email'                => 'user@domain.com',
            'password'             => bcrypt('password'),
            'email_verified_at'    => session('teamInvitation') ? now() : null,
            'is_active'            => 1,
            'is_office_login_only' => 0
        ]);

        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));

        // User::factory(['email' => 'raisul.me@gmail.com'])
        //     ->withPersonalTeam()
        //     ->hasAttached(Team::factory()->count(3))
        //     ->create();

    }
}