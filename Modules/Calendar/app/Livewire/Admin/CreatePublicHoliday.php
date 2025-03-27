<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\Admin;

use Carbon\CarbonImmutable;
use Livewire\Component;

class CreatePublicHoliday extends Component
{
    public PublicHolidayForm $form;

    public CarbonImmutable $date;

    public function add(): void
    {
        $this->form->date = $this->date->format('Y-m-d');
        $this->form->save();

        $this->dispatch('added');
        $this->dispatch('close', 'public-holiday-create-dialog-' . $this->date->format('Y-m-d'));
    }

    public function cancel()
    {
        $this->form->resetProperty();
    }

    public function render()
    {
        return view('calendar::admin.livewire.create-public-holiday');
    }
}
