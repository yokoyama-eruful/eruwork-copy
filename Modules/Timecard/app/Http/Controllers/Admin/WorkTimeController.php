<?php

declare(strict_types=1);

namespace Modules\Timecard\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class WorkTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('timecard::admin.index');
    }
}
