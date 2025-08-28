<?php

declare(strict_types=1);

namespace Modules\Shift\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('category') == 'week') {
            return view('shift::general.schedule.week');
        }

        return view('shift::general.schedule.day');
    }
}
