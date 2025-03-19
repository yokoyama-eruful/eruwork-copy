<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Calendar\Actions\CalendarManager;
use Modules\Calendar\Models\PublicHoliday;
use Modules\Calendar\Models\Schedule;

class Widget extends Component
{
    public CarbonImmutable $startDate;

    public CarbonImmutable $endDate;

    public array $shiftSchedules = [];

    public array $schedules = [];

    public function mount()
    {
        $this->setToday();

        $this->reloadCalendar();
    }

    public function setPeriod($startDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $startDate->addDays(6);
    }

    public function setToday()
    {
        $this->setPeriod(CarbonImmutable::now()->startOfDay());

        $this->reloadCalendar();
    }

    public function setPreviousDay()
    {
        $this->setPeriod($this->startDate->subDay());

        $this->reloadCalendar();
    }

    public function setNextDay()
    {
        $this->setPeriod($this->startDate->addDay());

        $this->reloadCalendar();
    }

    public function setPreviousWeek()
    {
        $this->setPeriod($this->startDate->subWeek());

        $this->reloadCalendar();
    }

    public function setNextWeek()
    {
        $this->setPeriod($this->startDate->addWeek());

        $this->reloadCalendar();
    }

    #[On('reloadCalendar')]
    public function reloadCalendar()
    {
        $this->shiftSchedules = CalendarManager::getMyShiftSchedule($this->startDate, $this->endDate);

        $this->schedules = CalendarManager::getSchedule($this->startDate, $this->endDate);
    }

    #[Computed]
    public function calendar()
    {
        $term = CarbonPeriodImmutable::create($this->startDate, $this->endDate);

        $holidays =
            PublicHoliday::whereBetween('date', [$this->startDate, $this->endDate])
                ->get();

        return $term
            ->map(function ($date) use ($holidays) {
                $type = '平日';
                $name = '';

                if ($date->format('w') === '0') {
                    $type = '土曜日';
                }

                if ($date->format('w') === '6') {
                    $type = '日曜日';
                }

                if ($holidays->where('date', $date)->isNotEmpty()) {
                    $type = '公休日';
                    $name = '（' . $holidays->where('date', $date)->first()->name . '）';
                }

                return [
                    'date' => $date,
                    'date_name' => $name,
                    'type' => $type,
                ];
            });
    }

    public function overlappingSchedules($shift)
    {
        $date = $shift->date;
        $startTime = $shift->start_time;
        $endTime = $shift->end_time;

        return Schedule::where('id', '!=', $shift->id)->where('user_id', Auth::id())
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->exists();
    }

    public function overlappingShifts($shift)
    {
        $date = $shift->date;
        $startTime = $shift->start_time;
        $endTime = $shift->end_time;

        return Schedule::where('user_id', Auth::id())
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->exists();
    }

    public function render()
    {
        return view('calendar::livewire.widget');
    }
}
