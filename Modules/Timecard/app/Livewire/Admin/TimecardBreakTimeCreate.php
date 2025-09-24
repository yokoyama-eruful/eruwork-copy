<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;
use Modules\Timecard\Livewire\Admin\Forms\BreakTimeForm;

class TimecardBreakTimeCreate extends Component
{
    public User $user;

    public CarbonImmutable $date;

    public BreakTimeForm $form;

    public function mount(User $user, $selectDate)
    {
        $this->user = $user;
        $this->date = CarbonImmutable::parse($selectDate);
        $this->form->user = $this->user;
        $this->form->in_date = $this->date->format('Y-m-d');
        $this->form->out_date = $this->date->format('Y-m-d');
    }

    public function storeBreakTime()
    {
        $this->form->create();
        $this->dispatch('close-modal', 'create-break-time-modal-' . $this->user->id);
        $this->dispatch('updated');
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.break-time.create');
    }
}
