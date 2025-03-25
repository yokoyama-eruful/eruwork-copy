<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\General;

use Livewire\Component;
use Modules\Shift\Models\Manager;

class SubmissionEditModal extends Component
{
    public $schedule;

    public Manager $manager;

    public SubmissionForm $form;

    public function mount()
    {
        $this->form->setData($this->schedule);
    }

    public function update()
    {
        $scheduleId = $this->schedule->id;

        $this->form->update();

        $this->schedule->refresh();

        $this->dispatch('edited');
        $this->dispatch('close-modal', 'edit-dialog-' . $scheduleId);
    }

    public function delete()
    {
        $scheduleId = $this->schedule->id;

        $this->form->delete();

        $this->dispatch('edited');
        $this->dispatch('close-modal', 'edit-dialog-' . $scheduleId);
    }

    public function render()
    {
        return view('shift::general.livewire.submission-edit-modal');
    }
}
