<?php

declare(strict_types=1);

namespace Modules\Calendar\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PublicHolidayController extends Controller
{
    public function __invoke()
    {
        return view('calendar::admin.index');
    }
}
