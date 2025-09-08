<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;

class TimecardShow extends Component
{
    public User $user;

    public $date;

    public $year;

    public $month;

    public $day;

    public function mount($user, $date)
    {
        $this->user = $user;
        $this->date = CarbonImmutable::parse($date);

        $this->year = $this->date->year;
        $this->month = $this->date->month;
        $this->day = $this->date->day;
    }

    public function getWorkTimeList($user)
    {
        return $user->workTime()->whereDate('date', $this->date)->get();
    }

    public function getBreakTimeList($user)
    {
        return $user->breakTime()->whereDate('date', $this->date)->get();
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
        return view('timecard::admin.timecard.livewire.show');
    }
}
