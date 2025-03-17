<?php

declare(strict_types=1);

namespace Modules\Shift\Http\Controllers;

use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('shift::schedule.index');
    }
}
