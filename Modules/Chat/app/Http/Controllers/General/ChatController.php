<?php

declare(strict_types=1);

namespace Modules\Chat\Http\Controllers\General;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Chat\Models\Group;

class ChatController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chat::general.index');
    }

    /**
     * Show the specified resource.
     */
    public function show(Group $group)
    {
        $this->authorize('view', $group);

        ChatEvent::dispatch();

        return view('chat::general.show', ['selectGroup' => $group]);
    }
}
