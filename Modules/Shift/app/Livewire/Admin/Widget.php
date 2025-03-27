<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use Livewire\Component;
use Modules\Shift\Models\Schedule;

class Widget extends Component
{
    public $todayShiftList;

    public $tomorrowShiftList;

    public function mount()
    {
        $this->todayShiftList = Schedule::query()
            ->whereDate('date', now())
            ->orderBy('start_time')
            ->with('user.profile')
            ->get()
            ->toBase()
            ->groupBy(function ($schedule) {
                return $schedule->user->name;
            });

        $this->tomorrowShiftList = Schedule::query()
            ->whereDate('date', now()->addDay())
            ->orderBy('start_time')
            ->with('user.profile')
            ->get()
            ->toBase()
            ->groupBy(function ($schedule) {
                return $schedule->user->name;
            });

    }

    public function render()
    {
        return view('shift::admin.livewire.widget');
    }
}
