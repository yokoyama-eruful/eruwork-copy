<?php

declare(strict_types=1);

namespace Modules\Calendar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Calendar\Http\Requests\ScheduleRequest;
use Modules\Calendar\Models\Schedule;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('calendar::general.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleRequest $request)
    {
        Schedule::create(
            [
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]
        );

        return to_route('calendar.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScheduleRequest $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $schedule->update(
            [
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]
        );

        return to_route('calendar.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return to_route('calendar.index');
    }
}
