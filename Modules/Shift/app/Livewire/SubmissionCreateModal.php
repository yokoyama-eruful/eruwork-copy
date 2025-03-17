<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire;

use Carbon\CarbonImmutable;
use Livewire\Component;
use Modules\Shift\Models\Manager;

class SubmissionCreateModal extends Component
{
    public SubmissionForm $form;

    public CarbonImmutable $day;

    public Manager $manager;

    public function mount()
    {
        $this->form->date = $this->day->format('Y-m-d');
        $this->form->managerId = $this->manager->id;
    }

    public function save()
    {
        $date = $this->form->date;

        $this->form->save();

        $this->dispatch('added');
        $this->form->date = $this->day->format('Y-m-d');
        $this->dispatch('close-modal', 'create-dialog-' . $date);
    }

    public function render()
    {
        return view('shift::livewire.submission-create-modal');
    }
}
