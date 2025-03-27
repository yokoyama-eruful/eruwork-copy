<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\Shift\Models\DraftSchedule;
use Modules\Shift\Models\Manager;
use Modules\Shift\Models\Schedule;

class Calendar extends Component
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

        $managerTerm = CarbonPeriodImmutable::create(
            $this->manager->start_date,
            $this->manager->end_date
        );

        $calendarContents =
            $calendarViewTerm
                ->map(function ($date) use ($managerTerm) {
                    return [
                        'date' => $date,
                        'type' => $this->getDateType($managerTerm, $date),
                        'shifts' => $this->getShifts($date),
                        'drafts' => $this->getDraftShifts($date),
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

    private function getShifts($date)
    {
        return Schedule::with(['draftSchedule', 'user'])
            ->where('date', $date)
            ->orderBy('start_time', 'asc')
            ->get()
            ->toBase()
            ->groupBy(function ($schedule) {
                return $schedule->user->name;
            });
    }

    private function getDraftShifts($date)
    {
        return DraftSchedule::with(['shiftSchedule', 'user'])
            ->where('date', $date)
            ->where('status', '未承認')
            ->where('manager_id', $this->manager->id)
            ->orderBy('start_time', 'asc')
            ->get()
            ->toBase()
            ->groupBy(function ($schedule) {
                return $schedule->user->name;
            });
    }

    public function render()
    {
        return view('shift::admin.livewire.calendar');
    }
}
