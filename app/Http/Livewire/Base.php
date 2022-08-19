<?php

namespace App\Http\Livewire;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Base extends Component
{
    public function mount()
    {
        Paginator::defaultView('vendor/pagination/tailwind');
        Paginator::defaultSimpleView('vendor/pagination/simple-tailwind');

        //if user is logged in
        if (auth()->check()) {
            foreach ($this->getPermissions() as $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            }

            //if user is not active log the user out
            if (!user()->is_active) {
                flash('Your account has been deactivated. You cannot login.')->warning();

                //creating the price will cause an activity being logged
        $activity = Activity::all()->last();

        $activity->description; //returns 'created'
        $activity->subject;     //returns the instance of model that was created
        $activity->changes;     //returns ['attributes' => [...]];

                auth()->logout();

                redirect(route('login'));
            }
        } else {
            redirect(route('login'));
        }
    }

    protected function getPermissions(): Collection
    {
        return Permission::with('roles')->get();
    }
}