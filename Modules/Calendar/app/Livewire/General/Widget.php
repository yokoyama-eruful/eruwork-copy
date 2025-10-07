<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\General;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Calendar\Actions\CalendarManager;
use Modules\Calendar\Models\PublicHoliday;
use Modules\Calendar\Models\Schedule;
use Modules\Shift\Models\Schedule as ShiftSchedule;

class Widget extends Component
{
    public CarbonImmutable $startDate;

    public CarbonImmutable $endDate;

    public array $shiftSchedules = [];

    public array $schedules = [];

    public int $year;

    public int $month;

    public int $day;

    public array $pullDownMenu = [];

    // モバイル用
    public $selectDate;

    public $mobileSchedules;

    public $mobileShiftSchedules;

    public function mount()
    {
        $this->setToday();
        $this->updateDays();

        $this->reloadCalendar();

        $this->selectedDate(now()->format('Y-m-d'));
    }

    public function setPeriod($startDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $startDate->addDays(6);
    }

    public function setToday()
    {
        $this->setPeriod(CarbonImmutable::now()->startOfDay());
        $this->year = CarbonImmutable::now()->year;
        $this->month = CarbonImmutable::now()->month;
        $this->day = CarbonImmutable::now()->day;

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

        $shifts = ShiftSchedule::where('user_id', Auth::id())
            ->whereBetween('date', [$term->first(), $term->last()])
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($shift) {
                return $shift->date->format('Y-m-d');
            });

        $schedules = Schedule::where('user_id', Auth::id())
            ->whereBetween('date', [$term->first(), $term->last()])
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($schedule) {
                return $schedule->date->format('Y-m-d');
            });

        $holidays =
            PublicHoliday::whereBetween('date', [$this->startDate, $this->endDate])
                ->get();

        return iterator_to_array($term->map(function ($date) use ($shifts, $schedules, $holidays) {
            $value = $this->getDayType($date, $holidays);

            return [
                'date' => $date,
                'date_name' => $value['name'],
                'type' => $value['type'],
                'shifts' => $shifts->has($date->format('Y-m-d')) ? $shifts[$date->format('Y-m-d')] : [],
                'schedules' => $schedules->has($date->format('Y-m-d')) ? $schedules[$date->format('Y-m-d')] : [],
            ];
        }));
    }

    private function getDayType(CarbonImmutable $date, $holidays): array
    {
        $value = [];

        if ($holidays->where('date', $date)->isNotEmpty()) {
            $value = [
                'type' => '公休日',
                'name' => '（' . $holidays->where('date', $date)->first()->name . '）',
            ];

            return $value;
        }

        return match ($date->dayOfWeek) {
            CarbonImmutable::SATURDAY => ['type' => '土曜日', 'name' => ''],
            CarbonImmutable::SUNDAY => ['type' => '日曜日', 'name' => ''],
            default => ['type' => '平日', 'name' => ''],
        };
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

    public function updateCalendar(): void
    {
        $this->setPeriod(CarbonImmutable::create($this->year, $this->month, $this->day)->startOfDay());
        $this->updateDays();
    }

    public function updateDays(): void
    {
        $daysInCurrentMonth = CarbonImmutable::create($this->year, $this->month)->daysInMonth;

        $this->pullDownMenu = [
            'year' => range(2000, 2050),
            'month' => range(1, 12),
            'day' => range(1, $daysInCurrentMonth),
        ];
    }

    public function getYesterday($day)
    {
        $previousDate = CarbonImmutable::parse($day)->subDay()->toDateString();

        return ShiftSchedule::where('user_id', Auth::id())
            ->where('date', $previousDate)
            ->orderBy('start_time', 'desc')
            ->first();
    }

    public function getYesterdayHeight($day)
    {
        $yesterdayShift = $this->getYesterday($day);
        $minuteStart = (int) $yesterdayShift->start_time->format('i');
        $hourEnd = (int) $yesterdayShift->end_time->format('H');
        $minuteEnd = (int) $yesterdayShift->end_time->format('i');

        $height = ($hourEnd) * 50 + ($minuteEnd - $minuteStart >= 30 ? 25 : 0);
        if ($height <= 60) {
            $height = 60;
        }

        return $height;
    }

    // モバイル用
    public function selectedDate($date)
    {
        $this->selectDate = CarbonImmutable::parse($date);

        $this->mobileShiftSchedules = ShiftSchedule::where('date', $date)
            ->where('user_id', Auth::id())
            ->get();

        $this->mobileSchedules = Schedule::where('date', $date)
            ->where('user_id', Auth::id())
            ->get();
    }

    public function render()
    {
        return view('calendar::general.livewire.widget');
    }
}
