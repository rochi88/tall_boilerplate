<?php

namespace Modules\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Index extends Component
{
    use Actions;
    use WithPagination;

    // Search
    public string $search = '';
    protected $queryString = ['search'];

    // Select Rows
    public $selectedRows = [];
    public $selectAllRows = false;
    public $selectAll = false;

    // Options to render table
    public array $tableOptions;

    // Listeners
    public $listeners = [
        'users::index::refresh' => '$refresh',
        'users::index::reset-table' => 'resetTable'
    ];

    public function render()
    {
        $this->tableOptions = [
            'selectedRows' => $this->selectedRows,
            'selectAll' => $this->selectAll,
            'collection' => $this->churches,
            'titles' => [
                'name',
                'email'
            ],
            'values' => [
                'name',
                'email',
            ]
        ];

        return view('users::livewire.users.index', [
            'tableOptions' => $this->tableOptions
        ]);
    }

    public function showCreateForm()
    {
        $this->emit('users::users.create');
    }
    
    public function edit($id)
    {
        $this->emit('users::users.update', $id);
    }

    public function delete($id = null)
    {
        if ($id) {
            User::find($id)->delete();
        } else {
            User::whereIn('id', $this->selectedRows)->delete();
        }

        $this->resetTable();

        $this->notification()->success(
            $title = 'Igreja excluída com sucesso!',
        );
    }

    public function getChurchesProperty()
    {
        return $this->churchesQuery->paginate(5);
    }

    public function getChurchesQueryProperty()
    {
        $query = User::query()
            ->latest()
            ->when($this->search, function ($q) {
                return $q->where('name', 'like', "%{$this->search}%");
            });

        return $query;
    }

    public function isChecked($id)
    {
        return in_array($id, $this->selectedRows);
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->selectedRows = $this->churchesQuery->pluck('id')
            ->map(fn ($item) => (string) $item)
            ->toArray();
    }

    public function updatedSelectAllRows($value)
    {
        $this->selectAll = false;
        if ($value) {
            $this->selectedRows = $this->churches->pluck('id')
                ->map(fn ($item) => (string) $item)
                ->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function updatedSelectedRows()
    {
        if ($this->churchesQuery->pluck('id')->count() === count($this->selectedRows)) {
            $this->selectAllRows = true;
            $this->selectAll = true;
        } elseif ($this->churches->pluck('id')->count() === count($this->selectedRows)) {
            $this->selectAllRows = true;
            $this->selectAll = false;
        } else {
            $this->selectAllRows = false;
            $this->selectAll = false;
        }
    }

    public function resetTable()
    {
        $this->selectedRows = [];
        $this->selectAllRows = false;
        $this->selectAll = false;
        $this->emitSelf('users::index::refresh');
    }

    public function updatedSearch()
    {
        $this->resetTable();
    }
}
