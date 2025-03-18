<?php

declare(strict_types=1);

namespace Modules\Shift\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Shift\Models\Manager;
use Modules\Shift\Models\Schedule;

class ShiftController extends Controller
{
    public function index()
    {
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
            $user = User::find($shift->user_id);
            if ($user) {
                $userSchedules[$user->id]['schedules'][] = $shift;
            }
        }

        return view('shift::index', ['managers' => $managers, 'userSchedules' => $userSchedules]);
    }
}
