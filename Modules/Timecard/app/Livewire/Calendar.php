<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Timecard\Models\Attendance;
use Modules\Timecard\Models\BreakTime;

class Calendar extends Component
{
    #[Url(as: 'yearMonth')]
    public ?string $yearMonth = null;

    public CarbonImmutable $viewYearMonth;

    public int $viewYear;

    public int $viewMonth;

    public CarbonImmutable $selectedDate;

    public array $pullDownMenu = [];

    public function mount(): void
    {
        $this->pullDownMenu = [
            'year' => range(2000, 2050),
            'month' => range(1, 12),
        ];

        if (
            $this->yearMonth
            && mb_strlen($this->yearMonth) === 6
            && mb_substr($this->yearMonth, 0, 1) === '2'
        ) {
            $this->viewYearMonth = CarbonImmutable::parse($this->yearMonth . '01');
        } else {
            $this->viewYearMonth = CarbonImmutable::now()->startOfMonth();
        }

        $this->viewYear = $this->viewYearMonth->year;
        $this->viewMonth = $this->viewYearMonth->month;

        $this->clickDate(CarbonImmutable::now()->format('Y-m-d'));

    }

    public function getToday()
    {
        $this->viewYearMonth = CarbonImmutable::now()->startOfMonth();

        $this->viewYear = $this->viewYearMonth->year;
        $this->viewMonth = $this->viewYearMonth->month;
        $this->selectedDate = $this->viewYearMonth;
    }

    public function pullDownDateMenu(): void
    {
        $this->viewYearMonth = CarbonImmutable::create($this->viewYear, $this->viewMonth);
    }

    public function clickDate($date): void
    {
        $this->selectedDate = CarbonImmutable::parse($date);
    }

    public function lastMonth(): void
    {
        $this->viewYearMonth = $this->viewYearMonth->subMonth()->startOfMonth();
        $this->viewYear = $this->viewYearMonth->year;
        $this->viewMonth = $this->viewYearMonth->month;
        $this->yearMonth = $this->viewYearMonth->format('Ym');
        $this->selectedDate = $this->viewYearMonth;
    }

    public function nextMonth(): void
    {
        $this->viewYearMonth = $this->viewYearMonth->addMonth()->startOfMonth();
        $this->viewYear = $this->viewYearMonth->year;
        $this->viewMonth = $this->viewYearMonth->month;
        $this->yearMonth = $this->viewYearMonth->format('Ym');
        $this->selectedDate = $this->viewYearMonth;
    }

    #[On('reloadCalendar')]
    public function reloadCalendar(): void
    {
        $this->calendar();
    }

    #[Computed()]
    public function calendar()
    {
        $period = CarbonPeriodImmutable::create(
            $this->viewYearMonth->startOfMonth()->startOfWeek(CarbonImmutable::MONDAY),
            $this->viewYearMonth->endOfMonth()->endOfWeek(CarbonImmutable::SUNDAY)
        );

        $attendances =
            Attendance::with('breakTimes')->where('user_id', Auth::id())
                ->whereYear('date', $this->viewYearMonth->year)
                ->whereMonth('date', $this->viewYearMonth->month)
                ->orderBy('in_time', 'asc')
                ->get()
                ->groupBy(function ($attendance) {
                    return $attendance->date->toDateString();
                });

        // $holidays = PublicHoliday::whereBetween('date', [$period->first(), $period->last()])->get();

        return
            $period
                ->map(function ($date) use ($attendances) {
                    $type = '平日';

                    if ($date->format('w') === '6') {
                        $type = '土曜日';
                    }

                    if ($date->format('w') === '0') {
                        $type = '日曜日';
                    }

                    // if ($holidays->where('date', $date)->isNotEmpty()) {
                    //     $type = '公休日';
                    // }

                    if ($date->format('m') !== $this->viewYearMonth->format('m')) {
                        $type = '補助日';
                    }

                    return [
                        'date' => $date,
                        'type' => $type,
                        'attendances' => $attendances->get($date->toDateString(), collect()),
                    ];
                });
    }

    #[Computed]
    public function workTime(): Collection
    {
        return
         Attendance::where('user_id', Auth::id())
             ->where('date', $this->selectedDate)
             ->orderBy('in_time', 'asc')
             ->get();
    }

    #[Computed]
    public function breakTime(): Collection
    {
        return
            BreakTime::where('user_id', Auth::id())
                ->where('date', $this->selectedDate)
                ->orderBy('start_time', 'asc')
                ->get();
    }

    #[Computed]
    public function workingTotalTime(): string
    {
        $attendances = Attendance::where('user_id', Auth::id())
            ->whereYear('date', $this->viewYearMonth->year)
            ->whereMonth('date', $this->viewYearMonth->month)
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->get();

        $workingTime = $attendances->map(function ($attendance) {
            $inTime = $attendance->in_time;
            $outTime = $attendance->out_time;

            $totalAttendanceTime = $inTime->diffInMinutes($outTime);

            $totalBreakTime = 0;
            foreach ($attendance->breakTimes as $breakTime) {
                $breakTimeStart = $breakTime->start_time;
                $breakTimeEnd = $breakTime->end_time;

                $totalBreakTime = +$breakTimeStart->diffInMinutes($breakTimeEnd);
            }

            return $totalAttendanceTime - $totalBreakTime;
        })->sum();

        $formatTime = function ($minutes) {
            $hours = floor($minutes / 60);
            $minutes = $minutes % 60;

            return sprintf('%01d時間%02d分', $hours, $minutes);
        };

        return $formatTime($workingTime);
    }

    public function render()
    {
        return view('timecard::livewire.calendar.index');
    }
}
