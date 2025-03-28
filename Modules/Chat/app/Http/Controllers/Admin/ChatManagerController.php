<?php

declare(strict_types=1);

namespace Modules\Chat\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Modules\Chat\Http\Requests\GroupStoreRequest;
use Modules\Chat\Http\Requests\GroupUpdateRequest;
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
            ->get();

        return view('chat::admin.index', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('id')->get();

        return view('chat::admin.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupStoreRequest $request)
    {
        $userIds = explode(',', $request->member);

        $manager = new ImageManager(new Driver);

        if ($request->icon) {
            $filePath = $request->icon->getRealPath();

            $image = $manager->read($filePath);

            $base64 = $image->resize(100, 100)->toPng()->toDataUri();
        }

        $group = Group::create([
            'name' => $request->name,
            'icon' => $base64 ?? null,
            'is_dm' => false,
        ]);

        $group->users()->sync($userIds);

        return to_route('chatManager.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $users = User::orderBy('id')->get();

        return view('chat::admin.edit', ['group' => $group, 'users' => $users, 'memberIds' => $group->users->pluck('id')->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupUpdateRequest $request, Group $group)
    {
        $userIds = explode(',', $request->member);

        $params = [
            'name' => $request->name,
        ];

        if ($request->icon) {
            $manager = new ImageManager(new Driver);

            $filePath = $request->icon->getRealPath();

            $image = $manager->read($filePath);

            $base64 = $image->resize(100, 100)->toPng()->toDataUri();
            $params['icon'] = $base64;
        }

        DB::transaction(function () use ($group, $params, $userIds) {
            $group->update($params);

            $group->users()->sync($userIds);

            $group->touch();
        });

        return to_route('chatManager.index');
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
