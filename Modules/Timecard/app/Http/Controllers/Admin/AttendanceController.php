<?php

declare(strict_types=1);

namespace Modules\Timecard\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('timecard::admin.attendance.index');
    }
}
