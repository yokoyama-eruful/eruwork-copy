<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class HourlyRateController extends Controller
{
    public function index()
    {
        return view('hourlyrate::index');
    }

    public function show(int $id)
    {
        $selectedUser = User::where('id', $id)->first();

        return view('hourlyrate::show', ['selectedUser' => $selectedUser]);
    }
}
