<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;
use Modules\Timecard\Livewire\Admin\Forms\WorkTimeForm;

class TimecardWorkTimeCreate extends Component
{
    public User $user;

    public CarbonImmutable $date;

    public WorkTimeForm $form;

    public function mount(User $user, $selectDate)
    {
        $this->user = $user;
        $this->date = CarbonImmutable::parse($selectDate);
        $this->form->user = $this->user;
        $this->form->date = $this->date;
    }

    public function storeWorkTime()
    {
        $this->form->create();
        $this->dispatch('close-modal', 'create-work-time-modal-' . $this->user->id);
        $this->dispatch('updated');
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.work-time.create');
    }
}
