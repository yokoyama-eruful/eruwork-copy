<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Calendar\Models\PublicHoliday;

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

        $holidays = PublicHoliday::whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->get();

        return iterator_to_array($period->map(function ($date) use ($holidays) {
            $type = $this->getDayType($date, $holidays);
            $holiday = $this->getPublicHoliday($date, $holidays);

            return [
                'date' => $date,
                'holiday' => $holiday,
                'type' => $type,
            ];
        }));
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

    private function getPublicHoliday($date, $holidays)
    {
        return $holidays->where('date', $date)->first();
    }

    public function render()
    {
        return view('calendar::admin.livewire.calendar');
    }
}
