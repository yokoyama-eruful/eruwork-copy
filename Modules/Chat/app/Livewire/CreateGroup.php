<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire;

use App\Events\ChatEvent;
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

    #[Computed()]
    public function users()
    {
        return User::orderBy('id')->whereNot('id', Auth::id())->get();
    }

    public function store()
    {
        $this->form->save();

        ChatEvent::dispatch();
    }

    public function render()
    {
        return view('chat::livewire.create-group');
    }
}
