<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateSchedule extends Component
{
    public ScheduleForm $form;

    public CarbonImmutable $date;

    public function add(): void
    {
        $this->form->date = $this->date->format('Y-m-d');
        $this->form->userId = Auth::id();
        $this->form->save();

        $this->dispatch('added');
        $this->dispatch('close', 'create-dialog-' . $this->date->format('Y-m-d'));
    }

    public function cancel()
    {
        $this->form->resetProperty();
    }

    public function render()
    {
        return view('calendar::livewire.create-schedule');
    }
}
