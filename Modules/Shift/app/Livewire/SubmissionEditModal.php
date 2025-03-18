<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire;

use Livewire\Component;

class SubmissionEditModal extends Component
{
    public $schedule;

    public SubmissionForm $form;

    public function mount()
    {
        $this->form->setData($this->schedule);
    }

    public function update()
    {
        $date = $this->form->date;

        $this->form->update();

        $this->schedule->refresh();

        $this->dispatch('edited');
        $this->dispatch('close-modal', 'edit-dialog-' . $date);
    }

    public function delete()
    {
        $date = $this->form->date;

        $this->form->delete();

        $this->dispatch('edited');
        $this->dispatch('close-modal', 'edit-dialog-' . $date);
    }

    public function render()
    {
        return view('shift::livewire.submission-edit-modal');
    }
}
