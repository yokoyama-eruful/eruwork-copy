<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\General;

use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Calendar\Models\PublicHoliday;
use Modules\Calendar\Models\Schedule;
use Modules\Shift\Models\Schedule as ShiftSchedule;

class Calendar extends Component
{
    public User $user;

    #[Url(as: 'year')]
    public int $year;

    #[Url(as: 'month')]
    public int $month;

    public CarbonImmutable $selectedDate;

    public function mount(): void
    {
        $currentDate = CarbonImmutable::now();
        $selectedDate = CarbonImmutable::create(
            $this->year ?? $currentDate->year,
            $this->month ?? $currentDate->month,
            $currentDate->day
        );

        $this->clickDate($selectedDate);

        $this->user = Auth::user();
    }

    public function clickDate($date): void
    {
        $this->selectedDate = CarbonImmutable::parse($date);
        $this->year = $this->selectedDate->year;
        $this->month = $this->selectedDate->month;
    }

    public function updateCalendar()
    {
        $this->selectedDate =
            CarbonImmutable::create($this->year, $this->month, $this->selectedDate->day);
    }

    #[Computed] #[On('reloadCalendar')]
    public function calendar()
    {

        $period = $this->getCalendarPeriod();

        $shifts = ShiftSchedule::where('user_id', $this->user->id)
            ->whereBetween('date', [$period->first(), $period->last()])
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($shift) {
                return $shift->date->format('Y-m-d');
            });

        $schedules = Schedule::where('user_id', $this->user->id)
            ->whereBetween('date', [$period->first(), $period->last()])
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($schedule) {
                return $schedule->date->format('Y-m-d');
            });

        $holidays = PublicHoliday::whereBetween('date', [$period->first(), $period->last()])->get();

        return $period->map(function ($date) use ($shifts, $schedules, $holidays) {
            $type = $this->getDayType($date, $holidays);

            return [
                'date' => $date,
                'type' => $type,
                'shifts' => $shifts->has($date->format('Y-m-d')) ? $shifts[$date->format('Y-m-d')] : [],
                'schedules' => $schedules->has($date->format('Y-m-d')) ? $schedules[$date->format('Y-m-d')] : [],
            ];
        });
    }

    private function getDayType(CarbonImmutable $date, $holidays): string
    {
        if ($date->format('m') !== $this->selectedDate->format('m')) {
            return '補助日';
        }

        if ($holidays->where('date', $date)->isNotEmpty()) {
            return '公休日';
        }

        return match ($date->dayOfWeek) {
            CarbonImmutable::SATURDAY => '土曜日',
            CarbonImmutable::SUNDAY => '日曜日',
            default => '平日',
        };
    }

    private function getCalendarPeriod()
    {
        $startDate = $this->selectedDate->startOfMonth()->startOfWeek(CarbonImmutable::MONDAY);
        $endDate = $startDate->addWeeks(5)->endOfWeek(CarbonImmutable::SUNDAY);

        return CarbonPeriodImmutable::create($startDate, $endDate);
    }

    public function overlappingSchedules($shift)
    {
        $date = $shift->date;
        $startTime = $shift->start_time;
        $endTime = $shift->end_time;

        return ShiftSchedule::where('id', '!=', $shift->id)->where('user_id', Auth::id())
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

    public function render()
    {
        return view('calendar::general.livewire.calendar');
    }
}
