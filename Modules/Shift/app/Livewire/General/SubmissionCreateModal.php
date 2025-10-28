<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\General;

use Carbon\CarbonImmutable;
use Livewire\Component;
use Modules\Shift\Models\Manager;

class SubmissionCreateModal extends Component
{
    public SubmissionForm $form;

    public CarbonImmutable $day;

    public Manager $manager;

    public string $item;

    public function mount()
    {
        $this->form->date = $this->day->format('Y-m-d');
        $this->form->managerId = $this->manager->id;
        $this->item = 'time';
    }

    public function save()
    {
        $date = $this->form->date;

        $this->form->save();

        $this->dispatch('added');
        $this->form->date = $this->day->format('Y-m-d');
        $this->dispatch('close-modal', 'create-modal-' . $date);
    }

    public function changeItem($item)
    {
        $this->item = $item;
    }

    public function selectPattern($startTime, $endTime)
    {
        $this->form->startTime = $startTime;
        $this->form->endTime = $endTime;
    }

    public function render()
    {
        return view('shift::general.livewire.submission-create-modal');
    }
}
