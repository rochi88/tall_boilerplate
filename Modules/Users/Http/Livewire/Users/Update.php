<?php

namespace Modules\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Update extends Component
{
    use Actions;

    public User $church;

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
        'churches::update' => 'show',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.roles.update');
    }

    public function show($id)
    {
        $this->church = User::find($id);

        $this->show = true;
    }

    public function save()
    {
        $this->validate([
            'church.church_name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('churches', 'church_name')->ignoreModel($this->church)
            ]
        ]);

        $this->notification()->success('Igreja atualizada com sucesso!');

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
