<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Shift\Models\DraftSchedule;
use Modules\Shift\Models\Schedule;

class ShiftTable extends Component
{
    public CarbonImmutable $date;

    public Collection $shifts;

    public Collection $drafts;

    public ShiftScheduleForm $form;

    public Collection $users;

    public function mount()
    {
        $this->users = User::orderBy('id')->get();
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

    public function downShift()
    {
        $date = $this->form->date;
        $this->form->delete();
        $this->dispatch('close-modal', 'edit-dialog-' . $this->form->schedule->id);
        $this->reloadSchedule($this->date);
    }

    public function reloadSchedule($date)
    {
        $date = CarbonImmutable::parse($date);

        $this->getShifts($date);
        $this->getDraftShifts($date);
    }

    public function getShifts(CarbonImmutable $date)
    {
        $shiftSchedules =
            Schedule::with(['draftSchedule', 'user'])
                ->where('date', $date)
                ->orderBy('start_time', 'asc')
                ->get()
                ->groupBy(function ($item) {
                    return $item->user->name;
                });

        $this->shifts = collect($shiftSchedules);
    }

    public function getDraftShifts($date)
    {
        $draftSchedules =
            DraftSchedule::with(['shiftSchedule', 'user'])
                ->whereDate('date', $date)
                ->where('status', '未承認')
                ->orderBy('start_time', 'asc')
                ->get()
                ->groupBy(function ($item) {
                    return $item->user->name;
                });

        $this->drafts = collect($draftSchedules);
    }

    public function setSchedule($scheduleId)
    {
        $schedule = Schedule::find($scheduleId);
        $this->form->setSchedule($schedule);
        $this->dispatch('open-modal', 'edit-dialog-' . $scheduleId);
    }

    public function save()
    {
        $this->form->date = $this->date;
        $this->form->save();

        $this->dispatch('close-modal', 'create-dialog-' . $this->date->format('Y-m-d'));
        $this->reloadSchedule($this->date);
    }

    public function update(): void
    {
        $this->form->update();
        $this->dispatch('close-modal', 'edit-dialog-' . $this->form->schedule->id);
        $this->reloadSchedule($this->form->date);
    }

    public function render()
    {
        return view('shift::admin.livewire.shift-table');
    }
}
