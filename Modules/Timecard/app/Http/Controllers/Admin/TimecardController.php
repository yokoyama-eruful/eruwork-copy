<?php

declare(strict_types=1);

namespace Modules\Timecard\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TimecardController extends Controller
{
    public function index()
    {
        return view('timecard::admin.timecard.index');
    }
}
