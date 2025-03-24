<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\Admin;

use Livewire\Component;

class MultiCreatePublicHoliday extends Component
{
    public PublicHolidayForm $form;

    public function add(): void
    {
        $this->form->save();

        $this->dispatch('reloadCalendar');
        $this->dispatch('reset-property');
        $this->dispatch('close-modal', 'multi-create-dialog');
    }

    public function cancel()
    {
        $this->form->resetProperty();
    }

    public function render()
    {
        return view('calendar::admin.livewire.multi-create-public-holiday');
    }
}
