<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Shift\Models\DraftSchedule;
use Modules\Shift\Models\Manager;
use Modules\Shift\Models\Schedule;

class Calendar extends Component
{
    public Manager $manager;

    public Collection $users;

    public CarbonImmutable $selectedDate;

    public ShiftScheduleForm $form;

    public $shifts;

    public function mount()
    {
        $this->users = User::orderBy('id')->get();
    }

    #[Computed] #[On('refreshShiftTable')]
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

        return iterator_to_array($calendarContents);
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
            ->get();
    }

    private function getDraftShifts($date)
    {
        return DraftSchedule::with(['shiftSchedule', 'user'])
            ->where('date', $date)
            ->where('status', '未承認')
            ->where('manager_id', $this->manager->id)
            ->orderBy('start_time', 'asc')
            ->get();
    }

    public function save($date)
    {
        $date = CarbonImmutable::parse($date);

        $this->form->date = $date;
        $this->form->save();

        $this->dispatch('close-modal', 'create-modal-' . $date->format('Y-m-d'));
        $this->reloadSchedule($date);
    }

    public function update(): void
    {
        $this->form->update();
        $this->dispatch('close-modal', 'edit-modal-' . $this->form->schedule->id);
        $this->reloadSchedule($this->form->date);
    }

    public function reloadSchedule($date)
    {
        $date = CarbonImmutable::parse($date);

        $this->getShifts($date);
        $this->getDraftShifts($date);

        $this->dispatch('refreshShiftTable');
    }

    public function setSchedule($scheduleId)
    {
        $schedule = Schedule::find($scheduleId);
        $this->form->setSchedule($schedule);
        $this->dispatch('open-modal', 'edit-modal-' . $scheduleId);
    }

    public function upShift(int $draftId)
    {
        $draft = DraftSchedule::find($draftId);

        $params = [
            'user_id' => $draft->user_id,
            'shift_draft_schedule_id' => $draft->id,
            'date' => $draft->date,
            'start_time' => $draft->start_time,
            'end_time' => $draft->end_time,
        ];

        Schedule::updateOrCreate(['shift_draft_schedule_id' => $draft->id], $params);

        $draft->update([
            'status' => '承認',
        ]);

        $this->reloadSchedule($draft->date);
    }

    public function downShift($date)
    {
        $this->form->delete();
        $this->dispatch('close-modal', 'edit-modal-' . $this->form->schedule->id);
        $this->reloadSchedule($date);
    }

    public function render()
    {
        return view('shift::admin.livewire.calendar');
    }
}
