<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\General;

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

    public $breakTime;

    public $currentDate;

    public $currentTime;

    public function mount()
    {
        $this->buttonStatus = $this->buttonStatus();

        $this->workTimes = $this->getTodayWorkTimes();
        $this->breakTime = $this->getTodayBreakTime();
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
        $this->breakTime = $this->getTodayBreakTime();
    }

    public function buttonStatus()
    {
        $workTime = WorkTime::where('user_id', Auth::id())
            ->whereNull('out_time')
            ->orderBy('in_time', 'desc')
            ->first();

        $breakTime = null;
        if ($workTime) {
            $breakTime = BreakTime::where('user_id', Auth::id())
                ->where('timecard__work_time_id', $workTime->id)
                ->whereNull('out_time')
                ->orderBy('in_time', 'desc')
                ->first();
        }

        return StampStatus::buttonStatus($workTime, $breakTime);
    }

    public function getTodayWorkTimes()
    {
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();

        return WorkTime::where('user_id', Auth::id())
            ->where(function ($query) use ($todayStart, $todayEnd) {
                $query->whereBetween('in_time', [$todayStart, $todayEnd])
                    ->orWhereBetween('out_time', [$todayStart, $todayEnd])
                    ->orWhere(function ($q) use ($todayStart, $todayEnd) {
                        $q->where('in_time', '<', $todayStart)
                            ->where('out_time', '>', $todayEnd);
                    });
            })
            ->orderBy('in_time', 'asc')
            ->get();
    }

    public function getTodayBreakTime()
    {
        $workTimes = $this->getTodayWorkTimes();

        $breakTimes = BreakTime::whereIn('timecard__work_time_id', $workTimes->pluck('id'))
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->get();

        $totalBreakMinutes = $breakTimes->sum(function ($breakTime) {
            $inTime = Carbon::parse($breakTime->in_time);
            $outTime = Carbon::parse($breakTime->out_time);

            return abs($outTime->diffInMinutes($inTime));
        });

        $hours = floor($totalBreakMinutes / 60);
        $minutes = $totalBreakMinutes % 60;

        return sprintf('%d時間%d分', $hours, $minutes);
    }

    public function render()
    {
        return view('timecard::general.livewire.stamp');
    }
}
