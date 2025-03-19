<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Timecard\Enums\StampStatus;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\Stamp as ModelsStamp;
use Modules\Timecard\Models\WorkTime;

class Stamp extends Component
{
    public $buttonStatus;

    public $workTimes;

    public $currentDate;

    public $currentTime;

    public function mount()
    {
        $this->buttonStatus = $this->buttonStatus();

        $this->workTimes = $this->getTodayWorkTimes();
        $this->currentDate = Carbon::now()->isoFormat('Y.M.D (ddd)');
        $this->currentTime = Carbon::now()->format('H:i');
    }

    public function updateClock()
    {
        $this->currentDate = Carbon::now()->isoFormat('Y.M.D (ddd)');
        $this->currentTime = Carbon::now()->format('H:i');
    }

    public function push(string $status)
    {
        ModelsStamp::push(
            CarbonImmutable::now(),
            StampStatus::from($status),
        );

        $this->buttonStatus = $this->buttonStatus();
        $this->workTimes = $this->getTodayWorkTimes();
    }

    public function buttonStatus()
    {
        $workTime =
            WorkTime::query()
                ->where('user_id', Auth::id())
                ->whereDate('date', now())
                ->whereNull('out_time')
                ->orderBy('in_time', 'desc')
                ->first();

        $breakTime =
            BreakTime::query()
                ->where('user_id', Auth::id())
                ->whereDate('date', now())
                ->whereNull('out_time')
                ->orderBy('in_time', 'desc')
                ->first();

        return StampStatus::buttonStatus($workTime, $breakTime);
    }

    public function getTodayWorkTimes()
    {
        return
            WorkTime::where('user_id', Auth::id())
                ->whereDate('date', now())
                ->orderBy('in_time', 'desc')
                ->first();
    }

    public function render()
    {
        return view('timecard::livewire.stamp');
    }
}
