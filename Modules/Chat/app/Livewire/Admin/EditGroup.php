<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire\Admin;

use App\Events\ChatEvent;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditGroup extends Component
{
    use WithFileUploads;

    public ChatGroupForm $form;

    public bool $showCreateDialog = false;

    public $group;

    public function mount($group)
    {
        $this->form->setGroup($group);
        $this->group = $group;
    }

    #[Computed()]
    public function users()
    {
        return User::orderBy('id')->get();
    }

    public function update()
    {
        $this->form->update();
        $this->dispatch('close-modal', 'group-edit-modal-' . $this->group->id);
        ChatEvent::dispatch();

        return redirect()->route('chatManager.index');
    }

    public function render()
    {
        return view('chat::admin.livewire.edit-group');
    }
}
