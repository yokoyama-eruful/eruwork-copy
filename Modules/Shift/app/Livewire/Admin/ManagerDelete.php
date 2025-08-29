<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use Livewire\Component;
use Modules\Shift\Models\Manager;

class ManagerDelete extends Component
{
    public Manager $manager;

    public function mount(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function render()
    {
        return view('shift::admin.livewire.manager-delete');
    }

    public function delete($managerId)
    {
        $manager = Manager::find($managerId);
        $manager->delete();

        return to_route('shiftManager.index');
    }
}
