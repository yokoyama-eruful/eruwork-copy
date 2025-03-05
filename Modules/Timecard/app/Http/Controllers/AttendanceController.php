<?php

declare(strict_types=1);

namespace Modules\Timecard\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Modules\Timecard\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all()->map(function ($attendance) {
            return [
                'id' => $attendance->id,
                'start' => $attendance->start_date->format('Y-m-dTH:i:s'),
                'end' => $attendance->end_date->format('Y-m-dTH:i:s'),
                'extendedProps' => [
                    'description' => $attendance->description,
                ],
            ];
        });

        return response()->json($attendances);
    }

    public function updateDate(Request $request, $id)
    {
        $attendance = Attendance::find($id);

        if (! $attendance) {
            return response()->json(['message' => 'attendance not found'], 404);
        }

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if ($start_date) {
            $attendance->start_date = CarbonImmutable::parse($start_date);
        }
        if ($end_date) {
            $attendance->end_date = CarbonImmutable::parse($end_date);
        }

        $attendance->save();

        return response()->json(['message' => 'attendance updated successfully']);
    }

    public function updateTime(Request $request, $id)
    {
        $attendance = Attendance::find($id);

        if (! $attendance) {
            return response()->json(['message' => 'attendance not found'], 404);
        }

        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');

        if ($start_time) {
            $attendance->start_time = CarbonImmutable::parse($start_time);
        }
        if ($end_time) {
            $attendance->end_time = CarbonImmutable::parse($end_time);
        }

        $attendance->save();

        return response()->json(['message' => 'attendance updated successfully']);
    }
}
