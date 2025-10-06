<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Timecard\Livewire\General\Dto\totalWorkingTimeDto;

class TimecardCalendar extends Component
{
    #[Url(as: 'user')]
    public User $user;

    public $year;

    public $month;

    public $day;

    #[Url(as: 'date')]
    public $selectDate;

    public function mount()
    {
        $this->user = Auth::user();

        $this->selectDate = now();
        $this->year = $this->selectDate->year;
        $this->month = $this->selectDate->month;
        $this->day = $this->selectDate->day;
    }

    #[Computed]
    public function daysInMonth()
    {
        if ($this->year && $this->month) {
            return CarbonImmutable::create($this->year, $this->month, 1)->daysInMonth;
        }

        return 31;
    }

    #[Computed]
    public function users()
    {
        return User::orderBy('id', 'asc')->paginate(10);
    }

    public function today()
    {
        $this->year = now()->year;
        $this->month = now()->month;
        $this->day = now()->day;

        $this->changeDate();
    }

    public function changeDate()
    {
        $this->selectDate = CarbonImmutable::create($this->year, $this->month, $this->day);
    }

    public function selectUser(User $selectedUser)
    {
        $this->user = $selectedUser;
    }

    public function getWorkTimeList($user)
    {
        return $user->workTime()->whereDate('in_time', $this->selectDate)->get();
    }

    public function getBreakTimeList($user)
    {
        return $user->breakTime()->whereDate('in_time', $this->selectDate)->get();
    }

    public function totalWorkTime()
    {
        $totalMonthWorkingTime = totalWorkingTimeDto::month($this->user, $this->selectDate);

        return $totalMonthWorkingTime;
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.index');
    }
}
