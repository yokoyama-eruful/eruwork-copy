<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;

class TimecardShow extends Component
{
    public User $user;

    public $date;

    public $year;

    public $month;

    public $day;

    public function mount($user, $date)
    {
        $this->user = $user;
        $this->date = CarbonImmutable::parse($date);

        $this->year = $this->date->year;
        $this->month = $this->date->month;
        $this->day = $this->date->day;
    }

    public function getWorkTimeList($user)
    {
        return $user->workTime()->whereDate('in_time', $this->date)->get();
    }

    public function getBreakTimeList($user)
    {
        return $user->breakTime()->whereDate('in_time', $this->date)->get();
    }

    public function totalWorkTime()
    {
        $workTimes = $this->user->workTime()->get();
        $breakTimes = $this->user->breakTime()->get();
        $totalMinutes = 0;

        foreach ($workTimes as $workTime) {
            $in = $workTime->in_time;
            $out = $workTime->out_time ?? now();

            $startOfMonth = CarbonImmutable::create($this->year, $this->month, 1, 0, 0, 0);
            $endOfMonth = $startOfMonth->endOfMonth()->setTime(23, 59, 59);

            $periodStart = $in->greaterThan($startOfMonth) ? $in : $startOfMonth;
            $periodEnd = $out->lessThan($endOfMonth) ? $out : $endOfMonth;

            if ($periodEnd->greaterThan($periodStart)) {
                $workMinutes = (int) round($periodStart->diffInSeconds($periodEnd) / 60);

                // この勤務に重なる休憩時間を引く
                foreach ($breakTimes as $breakTime) {
                    $bStart = $breakTime->in_time;
                    $bEnd = $breakTime->out_time ?? now();

                    // 休憩時間も月に収まるように調整
                    $bStart = $bStart->greaterThan($startOfMonth) ? $bStart : $startOfMonth;
                    $bEnd = $bEnd->lessThan($endOfMonth) ? $bEnd : $endOfMonth;

                    // 勤務時間と休憩時間の重なり
                    $overlapStart = $periodStart->greaterThan($bStart) ? $periodStart : $bStart;
                    $overlapEnd = $periodEnd->lessThan($bEnd) ? $periodEnd : $bEnd;

                    if ($overlapEnd->greaterThan($overlapStart)) {
                        $workMinutes -= (int) round($overlapStart->diffInSeconds($overlapEnd) / 60);
                    }
                }

                $totalMinutes += max($workMinutes, 0); // 負の値にならないように
            }
        }

        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%d:%02d', $hours, $minutes);
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.show');
    }
}
