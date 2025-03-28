<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Http\Controllers;

use App\Http\Controllers\Controller;

class HourlyRateController extends Controller
{
    public function __invoke()
    {
        return view('hourlyrate::index');
    }
}
