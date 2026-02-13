<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\General;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateSchedule extends Component
{
    public ScheduleForm $form;

    public $date;

    public function mount()
    {
        if (! $this->date) {
            $this->date = now();
        }
        $this->form->date = $this->date->format('Y-m-d');
    }

    public function add()
    {
        $this->form->userId = Auth::id();
        $this->form->save();

        $this->dispatch('added');
        $this->dispatch('close-modal', 'create-modal');
    }

    public function cancel()
    {
        $this->form->resetProperty();
    }

    public function render()
    {
        return view('calendar::general.livewire.create-schedule');
    }
}
