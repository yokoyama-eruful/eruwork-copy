<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire;

use App\Events\ChatEvent;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Chat\Models\Group;
use Modules\Chat\Models\Message;

class TalkArea extends Component
{
    public Group $group;

    public int $countMessage = 15;

    #[On('addViewMessage')]
    public function addViewMessage()
    {
        $this->countMessage = $this->countMessage + 5;
    }

    public function delete(int $messageId)
    {
        Message::destroy($messageId);

        ChatEvent::dispatch();
    }

    #[On('echo-private:chat-channel,ChatEvent')]
    public function render()
    {
        return view('chat::livewire.talk-area');
    }

    #[Computed]
    public function messages(): Collection
    {
        $messages = Message::where('group_id', $this->group->id)
            ->latest()
            ->take($this->countMessage)
            ->get();

        return $messages->reverse()->values();
    }
}
