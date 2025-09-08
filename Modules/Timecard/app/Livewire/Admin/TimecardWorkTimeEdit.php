<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use Livewire\Component;
use Modules\Timecard\Livewire\Admin\Forms\WorkTimeForm;
use Modules\Timecard\Models\WorkTime;

class TimecardWorkTimeEdit extends Component
{
    public WorkTime $workTime;

    public WorkTimeForm $form;

    public function mount(WorkTime $workTime)
    {
        $this->workTime = $workTime;

        $this->form->setValues($workTime);
    }

    public function updateWorkTime()
    {
        $this->form->update();
        $this->dispatch('close-modal', 'edit-work-time-modal-' . $this->workTime->id);
        $this->dispatch('updated');
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.work-time.edit');
    }
}
