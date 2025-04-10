<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\General;

use Livewire\Component;
use Modules\Shift\Models\Manager;

class Widget extends Component
{
    public int $count = 0;

    public function mount()
    {
        $today = now();
        $this->count = Manager::query()
            ->where('submission_start_date', '<=', $today)
            ->where('submission_end_date', '>=', $today)
            ->count();
    }

    public function render()
    {
        return view('shift::general.livewire.widget');
    }
}
