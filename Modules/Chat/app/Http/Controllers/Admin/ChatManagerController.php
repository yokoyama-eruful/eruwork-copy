<?php

declare(strict_types=1);

namespace Modules\Chat\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Chat\Models\Group;

class ChatManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups =
        Group::where('is_dm', false)
            ->orderBy('id')
            ->paginate(10);

        return view('chat::admin.index', ['groups' => $groups]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        Storage::deleteDirectory('chat/files/' . $group->id);

        $group->delete();

        return to_route('chatManager.index');
    }
}
