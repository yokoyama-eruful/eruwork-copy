<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Chat\Models\Group;
use Modules\Chat\Models\Message;

class TalkArea extends Component
{
    use WithPagination;

    public Group $group;

    public int $countMessage = 11;

    public function mount($groupId)
    {
        $this->group = Group::find($groupId);
    }

    #[On('addViewMessage')]
    public function addViewMessage()
    {
        $this->countMessage = $this->countMessage + 5;
    }

    public function delete(int $messageId)
    {
        Message::find($messageId)->delete();
    }

    #[On('reloadMessage')]
    public function render()
    {
        $messages = Message::where('group_id', $this->group->id)
            ->orderBy('created_at', 'desc')
            ->paginate($this->countMessage);

        return view('chat::livewire.talk-area', ['messages' => $messages]);
    }
}
