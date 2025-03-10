<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire;

use Carbon\CarbonImmutable;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Modules\Timecard\Livewire\Forms\BreakTimeForm;
use Modules\Timecard\Models\Attendance;

class CreateBreakTime extends Component
{
    public BreakTimeForm $form;

    #[Reactive]
    public CarbonImmutable $selectedDate;

    public bool $showCreateDialog = false;

    public function add(): void
    {
        if (! $this->canTakeBreak()) {
            session()->flash('status', '勤怠記録外の休憩はとれません');

            return;
        }

        $this->form->save($this->selectedDate);

        $this->reset('showCreateDialog');
        $this->dispatch('reloadCalendar');
    }

    private function canTakeBreak()
    {
        $attendances = Attendance::where('date', $this->selectedDate)->get();
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

    public function render()
    {
        return view('timecard::livewire.create-break-time');
    }
}
