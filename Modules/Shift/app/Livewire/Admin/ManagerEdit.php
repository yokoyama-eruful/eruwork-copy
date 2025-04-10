<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use Livewire\Component;
use Modules\Shift\Models\Manager;

class ManagerEdit extends Component
{
    public ShiftManagerForm $form;

    public function mount(Manager $manager)
    {
        $this->form->setValues($manager);
    }

    public function update()
    {
        $this->form->update();
        $this->dispatch('updated');
        $this->dispatch('close-modal', 'edit-modal');
    }

    public function render()
    {
        return view('shift::admin.livewire.manager-edit');
    }
}
