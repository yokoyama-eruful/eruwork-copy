<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire;

use Carbon\CarbonImmutable;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Modules\Timecard\Livewire\Forms\WorkTimeForm;

class CreateWorkTime extends Component
{
    public WorkTimeForm $form;

    #[Reactive]
    public CarbonImmutable $selectedDate;

    public bool $showCreateDialog = false;

    public function add(): void
    {
        $this->form->save($this->selectedDate);

        $this->reset('showCreateDialog');

        $this->dispatch('reloadCalendar');
    }

    public function render()
    {
        return view('timecard::livewire.create-work-time');
    }
}
