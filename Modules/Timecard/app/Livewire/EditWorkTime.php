<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire;

use Livewire\Component;
use Modules\Timecard\Livewire\Forms\WorkTimeForm;
use Modules\Timecard\Models\Attendance;

class EditWorkTime extends Component
{
    public Attendance $attendance;

    public WorkTimeForm $form;

    public bool $showEditDialog = false;

    public function mount(): void
    {
        $this->form->setAttendance($this->attendance);
    }

    public function update(): void
    {
        $this->form->update();

        $this->reset('showEditDialog');
        $this->dispatch('reloadCalendar');
    }

    public function delete(): void
    {
        $this->form->delete();

        $this->reset('showEditDialog');
        $this->dispatch('reloadCalendar');
    }

    public function render()
    {
        return view('timecard::livewire.edit-work-time');
    }
}
