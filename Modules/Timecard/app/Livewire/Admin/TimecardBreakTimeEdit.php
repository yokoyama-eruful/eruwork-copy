<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use Livewire\Component;
use Modules\Timecard\Livewire\Admin\Forms\BreakTimeForm;
use Modules\Timecard\Models\BreakTime;

class TimecardBreakTimeEdit extends Component
{
    public BreakTime $breakTime;

    public BreakTimeForm $form;

    public function mount(BreakTime $breakTime)
    {
        $this->breakTime = $breakTime;

        $this->form->setValues($breakTime);
    }

    public function updateBreakTime()
    {
        $this->form->update();
        $this->dispatch('close-modal', 'edit-break-time-modal-' . $this->breakTime->id);
        $this->dispatch('updated');
    }

    public function deleteBreakTime()
    {
        $this->form->delete();
        $this->dispatch('close-modal', 'delete-break-time-modal-' . $this->breakTime->id);
        $this->dispatch('updated');
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.break-time.edit');
    }
}
