<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\General;

use Livewire\Component;
use Modules\Calendar\Models\Schedule;

class DeleteSchedule extends Component
{
    public Schedule $schedule;

    public ScheduleForm $form;

    public function mount(): void
    {
        $this->form->setSchedule($this->schedule);
    }

    public function delete()
    {
        $this->form->delete();

        $this->dispatch('updated');
        $this->dispatch('close', 'schedule-delete-modal-' . $this->schedule->id);
    }

    public function render()
    {
        return view('calendar::general.livewire.delete-schedule');
    }
}
