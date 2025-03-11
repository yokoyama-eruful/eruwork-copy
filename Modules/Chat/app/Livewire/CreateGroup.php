<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateGroup extends Component
{
    use WithFileUploads;

    public ChatGroupForm $form;

    public bool $showCreateDialog = false;

    public array $selectedUsers = [];

    #[Computed()]
    public function users()
    {
        return User::orderBy('id')->whereNot('id', Auth::id())->get();
    }

    public function store()
    {
        dd($this->selectedUsers);
        $user = Auth::user();
        $this->selectedUsers = $this->selectedUsers + [$user->id => $user];

        $this->form->member = $this->selectedUsers;
        $this->form->save();
    }

    public function render()
    {
        return view('chat::livewire.create-group');
    }
}
