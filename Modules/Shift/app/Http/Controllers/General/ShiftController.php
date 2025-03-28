<?php

declare(strict_types=1);

namespace Modules\Shift\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Modules\Shift\Models\Manager;
use Modules\Shift\Models\Schedule;

class ShiftController extends Controller
{
    public function index()
    {
        // TODO
        $managers = Manager::get();

        $shifts = Schedule::where('date', now())
            ->get();

        $users = [];
        foreach ($shifts as $shift) {
            if ($shift->user) {
                $users[$shift->user_id] = $shift->user;
            }
        }

        $userSchedules = [];
        foreach ($users as $user) {
            $userSchedules[$user->id] = [
                'name' => $user->name,
                'schedules' => [],
            ];
        }

        foreach ($shifts as $shift) {
            $userSchedules[$shift->user_id]['schedules'][] = $shift;
        }

        return view('shift::general.index', ['managers' => $managers, 'userSchedules' => $userSchedules]);
    }
}
