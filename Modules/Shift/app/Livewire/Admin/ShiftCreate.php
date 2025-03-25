<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ShiftCreate extends Component
{
    public ShiftScheduleForm $form;

    public CarbonImmutable $date;

    public Collection $users;

    public function mount()
    {
        $this->users = User::orderBy('id')->get();
    }

    public function save(): void
    {
        $this->form->date = $this->date;
        $this->form->save();

        $this->dispatch('close-modal', 'create-dialog-' . $this->date->format('Y-m-d'));
        $this->dispatch("reloadSchedule.{$this->date}", $this->date->format('Y-m-d'));
    }

    public function render()
    {
        return view('shift::admin.livewire.shift-create');
    }
}
