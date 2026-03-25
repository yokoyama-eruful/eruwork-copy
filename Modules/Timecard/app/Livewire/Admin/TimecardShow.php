<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;
use Modules\Timecard\Livewire\General\Dto\totalWorkingTimeDto;
use Modules\Timecard\Support\WorkdayBoundary;

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
        $start = WorkdayBoundary::startOfDate($this->date);
        $end = WorkdayBoundary::endOfDate($this->date);

        return $user->workTime()
            ->where('in_time', '<', $end)
            ->where('out_time', '>', $start)
            ->get();
    }

    public function getBreakTimeList($user)
    {
        $start = WorkdayBoundary::startOfDate($this->date);
        $end = WorkdayBoundary::endOfDate($this->date);

        return $user->breakTime()
            ->where('in_time', '<', $end)
            ->where('out_time', '>', $start)
            ->get();
    }

    public function totalWorkTime()
    {
        return totalWorkingTimeDto::month($this->user, $this->date);
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.show');
    }
}
