<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\Admin;

use Livewire\Component;
use Modules\Calendar\Models\PublicHoliday;

class EditPublicHoliday extends Component
{
    public PublicHoliday $publicHoliday;

    public PublicHolidayForm $form;

    public function mount($publicHoliday): void
    {
        $this->publicHoliday = PublicHoliday::where('id', $publicHoliday->id)->firstOrFail();

        $this->form->setPublicHoliday($this->publicHoliday);
    }

    public function update()
    {
        $this->form->update();

        $this->dispatch('updated');
        $this->dispatch('close', 'edit-modal-' . $this->publicHoliday->id);
    }

    public function delete()
    {
        $this->form->delete();

        $this->dispatch('updated');
        $this->dispatch('close', 'edit-modal' . $this->publicHoliday->id);
    }

    public function render()
    {
        return view('calendar::admin.livewire.edit-public-holiday');
    }
}
