<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use Livewire\Component;

class ManagerCreate extends Component
{
    public ShiftManagerForm $form;

    public function save()
    {
        $this->form->save();

        $this->dispatch('close-modal', 'manager-create-dialog');

        return to_route('shiftManager.index');
    }

    public function render()
    {
        return view('shift::admin.livewire.manager-create');
    }
}
