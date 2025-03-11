<?php

declare(strict_types=1);

namespace Modules\Chat\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Chat\Enums\ChatGroupType;
use Modules\Chat\Models\Group;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $groups = $user->groups(ChatGroupType::ALL)
            ->get()
            ->sortByDesc(function ($group) {
                return $group->lastMessage ? $group->lastMessage->created_at : null;
            });

        return to_route('chat.show', ['id' => $groups->first()->id]);
    }

    /**
     * Show the specified resource.
     */
    public function show(Group $group)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $groups = $user->groups(ChatGroupType::ALL)
            ->get()
            ->sortByDesc(function ($group) {
                return $group->lastMessage ? $group->lastMessage->created_at : null;
            });

        return view('chat::show', ['groups' => $groups, 'selectGroup' => $group]);
    }
}
