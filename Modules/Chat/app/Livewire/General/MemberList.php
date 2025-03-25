<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire\General;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class MemberList extends Component
{
    public $selectGroup;

    #[Computed]
    public function groups()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return $user->groups()
            ->with('messages')
            ->get()
            ->sortByDesc(fn ($group) => $group->last_message?->created_at);
    }

    #[On('echo-private:chat-channel,ChatEvent')]
    public function render()
    {
        return view('chat::general.livewire.member-list');
    }
}
