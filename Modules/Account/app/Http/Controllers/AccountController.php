<?php

declare(strict_types=1);

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Account\Http\Requests\AccountStoreRequest;
use Modules\Account\Http\Requests\AccountUpdateRequest;
use Modules\Chat\Models\Group;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id')->paginate(10);

        return view('account::index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('account::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountStoreRequest $request)
    {
        $params = $request->params();

        $user = User::create($params['user']);

        if (array_key_exists('profile', $params)) {
            $user->profile()->create($params['profile']);
        }

        $user->roles()->sync($params['role']);

        $users = User::get();

        foreach ($users as $partner) {
            Group::open([$user, $partner]);
        }

        return to_route('account.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::where('login_id', $id)->first();

        return view('account::edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountUpdateRequest $request, $id)
    {
        $params = $request->params();
        $user = User::where('login_id', $id)->first();

        $user->touch();
        $user->update($params['user']);

        if (array_key_exists('profile', $params)) {
            $user->profile()
                ->updateOrCreate(
                    ['user_id' => $user->id],
                    $params['profile']
                );
        }

        if (isset($params['role'])) {
            $user->roles()->sync($params['role']);
        }

        return to_route('account.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::where('login_id', $id)->first();
        $user->delete();

        return to_route('account.index');
    }
}
