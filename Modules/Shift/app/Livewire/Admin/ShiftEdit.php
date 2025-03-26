<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Modules\Shift\Models\Schedule;

class ShiftEdit extends Component
{
    public Schedule $schedule;

    public ShiftScheduleForm $form;

    public Collection $users;

    public function mount(): void
    {
        $this->users = User::orderBy('id')->get();
        $this->form->setSchedule($this->schedule);
    }

    public function update(): void
    {
        $this->form->update();
        $this->dispatch('close-modal', 'edit-dialog-' . $this->schedule->id);
        $this->dispatch("reloadSchedule.{$this->form->date}", $this->form->date->format('Y-m-d'));
    }

    public function cancel(): void
    {
        $date = $this->form->date;
        $this->form->delete();
        $this->dispatch('close-modal', 'edit-dialog-' . $this->schedule->id);
        $this->dispatch("reloadSchedule.{$date}", $date->format('Y-m-d'));
    }

    public function render()
    {
        return view('shift::admin.livewire.shift-edit');
    }
}
