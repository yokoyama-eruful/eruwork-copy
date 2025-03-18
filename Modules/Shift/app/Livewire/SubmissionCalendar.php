<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\Shift\Models\DraftSchedule;
use Modules\Shift\Models\Manager;

class SubmissionCalendar extends Component
{
    public Manager $manager;

    public CarbonImmutable $selectedDate;

    #[Computed]
    public function calendar()
    {
        $calendarViewTerm = CarbonPeriodImmutable::create(
            $this->manager->start_date->startOfWeek(CarbonImmutable::MONDAY),
            $this->manager->end_date->endOfWeek(CarbonImmutable::SUNDAY)
        );

        $mangerTerm = CarbonPeriodImmutable::create(
            $this->manager->start_date,
            $this->manager->end_date
        );

        $calendarContents =
            $calendarViewTerm
                ->map(function ($date) use ($mangerTerm) {
                    return [
                        'date' => $date,
                        'type' => $this->getDateType($mangerTerm, $date),
                        'draftShifts' => $this->getDraftShifts($date),
                    ];
                });

        return $calendarContents;
    }

    private function getDateType($managerTerm, CarbonImmutable $date): string
    {
        // if ($holidays->where('date', $date)->isNotEmpty()) {
        //     return '公休日';
        // }

        if (! $managerTerm->contains($date)) {
            return '期間外';
        }

        return match ($date->dayOfWeek) {
            CarbonImmutable::SATURDAY => '土曜日',
            CarbonImmutable::SUNDAY => '日曜日',
            default => '平日',
        };
    }

    private function getDraftShifts($date)
    {
        return DraftSchedule::where('user_id', Auth::id())
            ->where('date', $date)
            ->where('manager_id', $this->manager->id)
            ->get();
    }

    public function render()
    {
        return view('shift::livewire.submission-calendar');
    }
}
