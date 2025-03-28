<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\General;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MultiCreateSchedule extends Component
{
    public ScheduleForm $form;

    public function add(): void
    {
        $this->form->userId = Auth::id();
        $this->form->save();

        $this->dispatch('reloadCalendar');
        $this->dispatch('reset-property');
        $this->dispatch('close-modal', 'multi-create-modal');
    }

    public function cancel()
    {
        $this->form->resetProperty();
    }

    public function render()
    {
        return view('calendar::general.livewire.multi-create-schedule');
    }
}
