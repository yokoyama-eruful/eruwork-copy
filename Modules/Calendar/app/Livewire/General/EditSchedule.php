<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\General;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Calendar\Models\Schedule;
use Modules\Shift\Models\Schedule as ShiftSchedule;

class EditSchedule extends Component
{
    public Schedule $schedule;

    public ScheduleForm $form;

    public function mount(): void
    {
        $this->form->setSchedule($this->schedule);
    }

    public function update()
    {
        $this->form->update();

        $this->dispatch('updated');
        $this->dispatch('close', 'schedule-edit-modal-' . $this->schedule->id);
    }

    public function overlappingSchedules()
    {
        $date = $this->schedule->date;
        $startTime = $this->schedule->start_time;
        $endTime = $this->schedule->end_time;

        return Schedule::where('id', '!=', $this->schedule->id)->where('user_id', Auth::id())
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->exists();
    }

    public function overlappingShifts()
    {
        $date = $this->schedule->date;
        $startTime = $this->schedule->start_time;
        $endTime = $this->schedule->end_time;

        return ShiftSchedule::where('id', '!=', $this->schedule->id)->where('user_id', Auth::id())
            ->where('date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->exists();
    }

    public function delete()
    {
        $this->form->delete();
        $this->dispatch('updated');
    }

    public function render()
    {
        return view('calendar::general.livewire.edit-schedule');
    }
}
