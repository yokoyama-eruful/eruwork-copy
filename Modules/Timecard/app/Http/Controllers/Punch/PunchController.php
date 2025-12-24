<?php

declare(strict_types=1);

namespace Modules\Timecard\Http\Controllers\Punch;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PunchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('user');

        $selectUser = User::find($query);

        $users = User::all();

        return view('timecard::punch.index', ['users' => $users, 'selectUser' => $selectUser]);
    }
}
