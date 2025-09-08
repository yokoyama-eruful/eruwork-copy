<?php

declare(strict_types=1);

namespace Modules\Timecard\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TimecardController extends Controller
{
    public function index()
    {
        return view('timecard::admin.timecard.index');
    }

    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return view('timecard::admin.timecard.show', ['user' => $user, 'date' => $request->query('date')]);
    }
}
