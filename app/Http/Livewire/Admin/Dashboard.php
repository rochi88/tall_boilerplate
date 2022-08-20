<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\Base;
use Illuminate\Contracts\View\View;

class Dashboard extends Base
{
    public function render(): View
    {
        return view('livewire.admin.dashboard');
    }
}