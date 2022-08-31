<?php

namespace Modules\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public ?User $church = null;

    public bool $show = false;

    public $rules = [
        'church.church_name' => 'required|string|max:100',
    ];

    public $messages = [
        'church.church_name.required' => 'O nome da igreja é obrigatório',
        'church.church_name.string' => 'O nome da igreja é obrigatório',
        'church.church_name.max' => 'O nome da igreja não pode ser superior a 100 caracteres',
    ];

    public $listeners = [
        'churches::create' => 'show',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.churches.create');
    }

    public function show()
    {
        $this->show = true;
    }

    public function save()
    {
        $this->validate();
        
        $this->church->save();

        $this->notification()->success('Igreja adicionada com sucesso!');

        $this->resetForm();
        $this->show = false;
        $this->emit('churches::index::reset-table');
    }

    public function resetForm()
    {
        $this->church = new User;

        $this->resetErrorBag();
    }

    public function updated($field)
    {
        $this->resetErrorBag($field);
    }
}
