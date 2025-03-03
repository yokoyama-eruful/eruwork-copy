<?php

declare(strict_types=1);

namespace Modules\Calendar\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Calendar\Models\Schedule;

class ScheduleController extends Controller
{
    public function __invoke()
    {
        $schedules = Schedule::all()->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => $schedule->title,
                'start' => $schedule->start_date->format('Y-m-d') . 'T' . $schedule->start_time->format('H:i:s'),
                'end' => $schedule->end_date->format('Y-m-d') . 'T' . $schedule->end_time->format('H:i:s'),
                'extendedProps' => [
                    'description' => $schedule->description,
                ],
            ];
        });

        return response()->json($schedules);
    }
}
