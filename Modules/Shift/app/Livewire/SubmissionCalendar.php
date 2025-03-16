<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Shift\Models\DraftSchedule;
use Modules\Shift\Models\Manager;

class SubmissionCalendar extends Component
{
    public Manager $manager;

    public SubmissionForm $form;

    public CarbonImmutable $selectedDate;

    public function mount($managerId)
    {
        $this->manager = Manager::findOrFail($managerId);
        $this->form->managerId = $this->manager->id;
    }

    #[Computed] #[On('reloadCalendar')]
    public function calendar()
    {
        // $drafts = $this->getDraftSchedules();

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
                        // 'drafts' => $this->findSchedules($drafts, $date),
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

    public function setDate($date)
    {
        $this->form->date = $date;

        $this->reset(['form.startTime', 'form.endTime']);
    }

    public function setData($id)
    {
        $draftSchedule = DraftSchedule::find($id);

        $this->form->setData($draftSchedule);
    }

    public function save()
    {
        $date = $this->form->date;

        $this->form->save();

        $this->dispatch('close-modal', 'create-dialog-' . $date);
    }

    public function update()
    {
        $date = $this->form->date;

        $this->form->update();

        $this->dispatch('close-modal', 'edit-dialog-' . $date);
    }

    public function render()
    {
        return view('shift::livewire.submission-calendar');
    }
}
