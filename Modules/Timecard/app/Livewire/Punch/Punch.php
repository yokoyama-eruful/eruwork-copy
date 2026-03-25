<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Punch;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Livewire\Component;
use Modules\Timecard\Enums\StampStatus;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\Rule;
use Modules\Timecard\Models\Stamp;
use Modules\Timecard\Models\WorkTime;
use Modules\Timecard\Support\WorkdayBoundary;

class Punch extends Component
{
    public $buttonStatus;

    public $workTimes;

    public $breakTime;

    public $currentDate;

    public $currentTime;

    public $rule;

    public $user;

    public function mount($user)
    {
        $businessDate = WorkdayBoundary::businessDate(CarbonImmutable::now());

        $this->buttonStatus = $this->buttonStatus();

        $this->workTimes = $this->getTodayWorkTimes();
        $this->breakTime = $this->getTodayBreakTime();
        $this->currentDate = $businessDate->isoFormat('Y/M/D (ddd)');
        $this->currentTime = Carbon::now()->format('H:i');
        $this->rule = Rule::first()?->rule ?? 'remote';
        $this->user = $user;
    }

    public function push(string $status)
    {
        Stamp::push(
            CarbonImmutable::now(),
            StampStatus::from($status),
            $this->user->id
        );

        $this->buttonStatus = $this->buttonStatus();
        $this->workTimes = $this->getTodayWorkTimes();
        $this->breakTime = $this->getTodayBreakTime();

        $this->dispatch('statusUpdate');
    }

    public function buttonStatus()
    {
        $workTime = WorkTime::where('user_id', $this->user->id)
            ->whereNull('out_time')
            ->orderBy('in_time', 'desc')
            ->first();

        $breakTime = null;
        if ($workTime) {
            $breakTime = BreakTime::where('user_id', $this->user->id)
                ->where('timecard__work_time_id', $workTime->id)
                ->whereNull('out_time')
                ->orderBy('in_time', 'desc')
                ->first();
        }

        return StampStatus::buttonStatus($workTime, $breakTime);
    }

    public function getTodayWorkTimes()
    {
        $today = WorkdayBoundary::businessDate(CarbonImmutable::now());
        $todayStart = WorkdayBoundary::startOfDate($today);
        $todayEnd = WorkdayBoundary::endOfDate($today);

        return WorkTime::where('user_id', $this->user->id)
            ->where(function ($query) use ($todayStart, $todayEnd) {
                $query->where('in_time', '<', $todayEnd)
                    ->where('out_time', '>', $todayStart);
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
        return view('timecard::punch.livewire.punch');
    }
}
