<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire;

use App\Events\ChatEvent;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
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

    public function render()
    {
        $this->group->reads()
            ->where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => CarbonImmutable::now()]);

        ChatEvent::dispatch();

        return view('chat::livewire.talk-area');
    }

    #[Computed] #[On('echo-private:chat-channel,ChatEvent')]
    public function messages(): Collection
    {
        $messages = Message::where('group_id', $this->group->id)
            ->latest()
            ->take($this->countMessage)
            ->get();

        return $messages->reverse()->values();
    }

    public function readStatus()
    {
        $this->group->reads()
            ->where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => CarbonImmutable::now()]);
    }
}
