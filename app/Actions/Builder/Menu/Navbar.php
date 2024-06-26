<?php

declare(strict_types = 1);

namespace App\Actions\Builder\Menu;

use App\Contracts\{Builder, Menu};
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{Gate, Route};

class Navbar implements Builder, Menu
{
    private Collection $menus;

    public function menus(): Collection
    {
        return $this->menus;
    }

    public function build(): self
    {
        $this->menus = collect([
            [
                'show'  => auth()->user() ? false : true,
                'route' => 'welcome',
                'label' => 'Welcome',
            ],
            [
                'show'  => auth()->user() ? false : Route::has('register'),
                'route' => 'register',
                'label' => 'Register',
            ],
            [
                'show'  => auth()->user() ? false : true,
                'route' => 'login',
                'label' => 'Login',
            ],
            [
                'show'  => auth()->user() ? true : false,
                'route' => 'dashboard',
                'label' => 'Dashboard',
            ],
            [
                'show'  => Gate::allows('viewAny', User::class),
                'route' => 'users.index',
                'label' => 'Users',
            ],
        ])->reject(fn ($menu) => $menu['show'] == false);

        return $this;
    }
}
