<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

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
        return $user->workTime()->whereDate('date', $this->selectDate)->get();
    }

    public function getBreakTimeList($user)
    {
        return $user->breakTime()->whereDate('date', $this->selectDate)->get();
    }

    // 詳細
    public function totalWorkTime()
    {
        $totalMinutes = (int) $this->user
            ->workTime()
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->selectRaw('SUM(EXTRACT(EPOCH FROM (out_time - in_time)) / 60) as total_minutes')
            ->value('total_minutes');

        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%d:%02d', $hours, $minutes);

    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.index');
    }
}
