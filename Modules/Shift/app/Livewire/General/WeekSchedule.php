<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\General;

use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\Shift\Models\Manager;
use Modules\Shift\Models\Schedule;

class WeekSchedule extends Component
{
    public Manager $manager;

    public Collection $users;

    public CarbonImmutable $startDate;

    public CarbonImmutable $endDate;

    public $selectDay = null;

    public int $viewYear;

    public int $viewMonth;

    public int $viewDay;

    public array $pullDownMenu = [];

    public function mount()
    {
        $today = now();
        $this->manager = Manager::all()
            ->filter(function ($manager) {
                return $manager->ReceptionStatus === '受付中';
            })
            ->sortBy(function ($manager) use ($today) {
                return abs($manager->submission_end_date->diffInDays($today));
            })
            ->first();

        $this->getToday();
        $this->updateDays();

        $this->users = User::orderBy('id')->get();
    }

    #[Computed]
    public function calendar()
    {
        $term = CarbonPeriodImmutable::create($this->startDate, $this->endDate);
        // $holidays = PublicHoliday::whereBetween('date', [$this->startDate, $this->endDate])->get()->keyBy('date');

        return collect($term)->map(fn ($date) => [
            'date' => $date,
            'type' => $this->determineDayType($date),
        ])->toArray();
    }

    #[Computed]
    public function shiftSchedules()
    {
        $shifts =
            Schedule::with('user')
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->orderBy('date')
                ->get();

        $period = CarbonPeriodImmutable::create($this->startDate, $this->endDate);

        $items = [];

        foreach ($this->users as $user) {
            $items[$user->id] = [
                'name' => $user->name,
                'schedules' => [],
            ];

            foreach ($period as $date) {
                $items[$user->id]['schedules'][$date->format('Y-m-d')] = $shifts
                    ->where('user_id', $user->id)
                    ->where('date', $date);
            }
        }

        return $items;
    }

    private function determineDayType($date): string
    {
        // if ($holidays->has($date->format('Y-m-d'))) {
        //     return '公休日';
        // }

        return match ($date->format('w')) {
            '0' => '日曜日',
            '6' => '土曜日',
            default => '平日',
        };
    }

    public function setToday(CarbonImmutable $date)
    {
        $this->viewYear = $date->year;
        $this->viewMonth = $date->month;
        $this->viewDay = $date->day;

        $this->setPeriod($date->startOfDay());
    }

    public function getToday(): void
    {
        $date = CarbonImmutable::now();

        $this->viewYear = $date->year;
        $this->viewMonth = $date->month;
        $this->viewDay = $date->day;

        $this->setPeriod($date->startOfDay());
    }

    public function pullDownDateMenu(): void
    {
        $this->setPeriod(CarbonImmutable::create($this->viewYear, $this->viewMonth, $this->viewDay)->startOfDay());
        $this->updateDays();
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

    public function setPreviousWeek(): void
    {
        $this->setPeriod($this->startDate->subWeek());

        $this->viewYear = $this->startDate->year;
        $this->viewMonth = $this->startDate->month;
        $this->viewDay = $this->startDate->day;
    }

    public function setNextWeek(): void
    {
        $this->setPeriod($this->startDate->addWeek());

        $this->viewYear = $this->startDate->year;
        $this->viewMonth = $this->startDate->month;
        $this->viewDay = $this->startDate->day;
    }

    private function setPeriod(CarbonImmutable $startDate): void
    {
        $this->startDate = $startDate;
        $this->endDate = $startDate->addDays(6);
    }

    public function selectDate($date)
    {
        $this->selectDay = CarbonImmutable::parse($date);
        $this->dispatch('open-modal', 'open-attendance-modal');
    }

    #[Computed]
    public function userSchedules()
    {
        // TODO
        if ($this->selectDay == null) {
            return;
        }

        $shifts = Schedule::where('date', $this->selectDay)
            ->orderBy('start_time')
            ->get();

        $userSchedules = [];

        foreach ($shifts as $shift) {
            $user = $this->users->firstWhere('id', $shift->user_id);
            if ($user) {
                $userName = $user->name;

                if (! isset($userSchedules[$userName])) {
                    $userSchedules[$userName] = [];
                }

                $userSchedules[$userName][] = $shift;
            }
        }

        return $userSchedules;
    }

    public function render()
    {
        return view('shift::general.livewire.week-schedule');
    }
}
