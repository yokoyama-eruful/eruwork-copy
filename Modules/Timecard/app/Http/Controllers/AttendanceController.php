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
                'start' => $attendance->date->format('Y-m-d') . 'T' . $attendance->in_time->format('H:i:s'),
                'end' => $attendance->date->format('Y-m-d') . 'T' . $attendance->out_time->format('H:i:s'),
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

        $date = $request->input('date');

        if ($date) {
            $attendance->date = CarbonImmutable::parse($date);
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

        $in_time = $request->input('in_time');
        $out_time = $request->input('out_time');

        if ($in_time) {
            $attendance->in_time = CarbonImmutable::parse($in_time);
        }
        if ($out_time) {
            $attendance->out_time = CarbonImmutable::parse($out_time);
        }

        $attendance->save();

        return response()->json(['message' => 'attendance updated successfully']);
    }
}
