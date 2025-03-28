<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\General;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Shift\Models\Schedule;

class DaySchedule extends Component
{
    public $date;

    public Collection $users;

    public int $viewYear;

    public int $viewMonth;

    public int $viewDay;

    public $userShiftSchedules;

    public $selected = [];

    public array $pullDownMenu = [];

    public function mount()
    {
        $this->getToday();

        $this->updateDays();

        $this->users = User::orderBy('id')->get();
    }

    public function updateDays(): void
    {
        $daysInCurrentMonth = CarbonImmutable::create($this->viewYear, $this->viewMonth)->daysInMonth;

        $this->pullDownMenu = [
            'year' => range(2000, 2050),
            'month' => range(1, 12),
            'day' => range(1, $daysInCurrentMonth),
        ];
    }

    public function setPreviousDay()
    {
        $this->date = $this->date->subDay();

        $this->setToday($this->date);
    }

    public function setNextDay()
    {
        $this->date = $this->date->addDay();

        $this->setToday($this->date);
    }

    public function setToday(CarbonImmutable $date)
    {
        $this->date = $date;

        $this->viewYear = $this->date->year;
        $this->viewMonth = $this->date->month;
        $this->viewDay = $this->date->day;
    }

    public function getToday()
    {
        $this->date = now();

        $this->viewYear = $this->date->year;
        $this->viewMonth = $this->date->month;
        $this->viewDay = $this->date->day;
    }

    public function pullDownDateMenu(): void
    {
        $this->date = CarbonImmutable::create($this->viewYear, $this->viewMonth, $this->viewDay);
        $this->updateDays();
    }

    public function getUserShiftSchedules()
    {
        if (empty($this->selected)) {
            $this->userShiftSchedules = $this->userShiftSchedules();
        } else {
            $this->userShiftSchedules = $this->attendanceUsers();
        }
    }

    public function userShiftSchedules()
    {
        // TODO
        $shifts = Schedule::where('date', $this->date)
            ->orderBy('user_id')
            ->orderBy('start_time')
            ->get();

        foreach ($this->users as $user) {
            $userShiftSchedules[$user->id] = [
                'name' => $user->name,
                'schedules' => [],
            ];
        }

        foreach ($shifts as $shift) {
            $user = User::find($shift->user_id);
            if ($user) {
                $userShiftSchedules[$user->id]['schedules'][] = $shift;
            }
        }

        return $userShiftSchedules;
    }

    public function attendanceUsers()
    {
        $shifts = Schedule::where('date', $this->date)
            ->orderBy('user_id')
            ->orderBy('start_time')
            ->get();

        $userSchedules = [];

        foreach ($shifts as $shift) {
            $user = User::find($shift->user_id);
            if ($user) {
                if (! isset($userSchedules[$user->id])) {
                    $userSchedules[$user->id] = [
                        'name' => $user->name,
                        'schedules' => [],
                    ];
                }
                $userSchedules[$user->id]['schedules'][] = $shift;
            }
        }

        return $userSchedules;
    }

    public function render()
    {
        $this->getUserShiftSchedules();

        return view('shift::general.livewire.day-schedule');
    }
}
