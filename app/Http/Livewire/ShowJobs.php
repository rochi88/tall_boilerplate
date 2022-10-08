<?php

namespace App\Http\Livewire;

use App\Models\Test;
use Livewire\Component;
use Livewire\WithPagination;

class ShowJobs extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.show-jobs', [
            'jobs' => Test::where('name', 'like', '%'.$this->search.'%')->paginate(5),
        ]);
    }
}
