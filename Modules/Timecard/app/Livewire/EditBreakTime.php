<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire;

use Carbon\CarbonImmutable;
use Livewire\Component;
use Modules\Timecard\Livewire\Forms\BreakTimeForm;
use Modules\Timecard\Models\Attendance;
use Modules\Timecard\Models\BreakTime;

class EditBreakTime extends Component
{
    public BreakTime $breakTime;

    public BreakTimeForm $form;

    public bool $showEditDialog = false;

    public function mount(): void
    {
        $this->form->setBreakTime($this->breakTime);
    }

    public function update(): void
    {
        if (! $this->canTakeBreak()) {
            session()->flash('status', '勤怠記録外の休憩はとれません');

            return;
        }

        $this->form->update();

        $this->reset('showEditDialog');
        $this->dispatch('reloadCalendar');
    }

    private function canTakeBreak()
    {
        $attendances = Attendance::where('date', $this->form->date)->get();
        $now = CarbonImmutable::now();

        $attendanceList = $attendances->map(function ($attendance) use ($now) {
            return [
                'id' => $attendance->id,
                'in_time' => $attendance->in_time ?? $now,
                'out_time' => $attendance->out_time ?? $now,
            ];
        });

        foreach ($attendanceList as $attendance) {
            $breakStart = CarbonImmutable::parse($this->form->startTime);
            $breakEnd = CarbonImmutable::parse($this->form->endTime);

            if (
                $breakStart >= ($attendance['in_time']) && $breakEnd <= $attendance['out_time']
            ) {
                $this->form->attendanceId = $attendance['id'];

                return true;
            }
        }

        return false;
    }

    public function delete(): void
    {
        $this->form->delete();

        $this->reset('showEditDialog');
        $this->dispatch('reloadCalendar');
    }

    public function render()
    {
        return view('timecard::livewire.edit-break-time');
    }
}
