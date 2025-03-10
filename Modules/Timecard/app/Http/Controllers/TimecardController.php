<?php

declare(strict_types=1);

namespace Modules\Timecard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Timecard\Http\Requests\AttendanceRequest;
use Modules\Timecard\Models\WorkTime;

class TimecardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('timecard::index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceRequest $request)
    {
        WorkTime::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'in_time' => $request->in_time,
            'out_time' => $request->out_time,
        ]);

        return to_route('timecard.index');
    }

    public function update(AttendanceRequest $request, $id)
    {
        dd($request);
        $attendance = WorkTime::findOrFail($id);

        $attendance->update(
            [
                'user_id' => Auth::id(),
                'date' => $request->date,
                'in_time' => $request->in_time,
                'out_time' => $request->out_time,
            ]
        );

        return to_route('timecard.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $attendance = WorkTime::findOrFail($id);
        $attendance->delete();

        return to_route('attendance.index');
    }
}
