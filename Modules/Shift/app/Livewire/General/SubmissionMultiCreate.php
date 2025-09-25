<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\General;

use Livewire\Component;
use Modules\Shift\Models\Manager;

class SubmissionMultiCreate extends Component
{
    public Manager $manager;

    public SubmissionForm $form;

    public function save()
    {
        $this->form->managerId = $this->manager->id;
        $this->form->multiSave();

        $this->dispatch('SubmissionCalendarAllRefresh');
        $this->dispatch('reset-property');
        $this->dispatch('close-modal', 'multi-create-modal');
    }

    public function render()
    {
        return view('shift::general.livewire.submission-multi-create');
    }
}
