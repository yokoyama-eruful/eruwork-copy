<?php

declare(strict_types=1);

namespace Modules\Calendar\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Modules\Calendar\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
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

    public function updateDate(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (! $schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if ($start_date) {
            $schedule->start_date = CarbonImmutable::parse($start_date);
        }
        if ($end_date) {
            $schedule->end_date = CarbonImmutable::parse($end_date);
        }

        $schedule->save();

        return response()->json(['message' => 'Schedule updated successfully']);
    }

    public function updateTime(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (! $schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');

        if ($start_time) {
            $schedule->start_time = CarbonImmutable::parse($start_time);
        }
        if ($end_time) {
            $schedule->end_time = CarbonImmutable::parse($end_time);
        }

        $schedule->save();

        return response()->json(['message' => 'Schedule updated successfully']);
    }
}
