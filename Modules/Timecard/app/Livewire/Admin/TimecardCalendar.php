<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Timecard\Livewire\General\Dto\totalWorkingTimeDto;

class TimecardCalendar extends Component
{
    #[Url(as: 'user')]
    public User $user;

    public $year;

    public $month;

    public $day;

    #[Url(as: 'date')]
    public $selectDate;

    public function mount()
    {
        $this->user = Auth::user();

        $this->selectDate = now();
        $this->year = $this->selectDate->year;
        $this->month = $this->selectDate->month;
        $this->day = $this->selectDate->day;
    }

    #[Computed]
    public function daysInMonth()
    {
        if ($this->year && $this->month) {
            return CarbonImmutable::create($this->year, $this->month, 1)->daysInMonth;
        }

        return 31;
    }

    #[Computed]
    public function users()
    {
        return User::orderBy('id', 'asc')->paginate(10);
    }

    public function changeDate()
    {
        $this->selectDate = CarbonImmutable::create($this->year, $this->month, $this->day);
    }

    public function selectUser(User $selectedUser)
    {
        $this->user = $selectedUser;
    }

    public function getWorkTimeList($user)
    {
        return $user->workTime()->whereDate('in_time', $this->selectDate)->get();
    }

    public function getBreakTimeList($user)
    {
        return $user->breakTime()->whereDate('in_time', $this->selectDate)->get();
    }

    public function totalWorkTime()
    {
        // $workTimes = $this->user->workTime()->get();
        // $breakTimes = $this->user->breakTime()->get();
        // $totalMinutes = 0;

        // foreach ($workTimes as $workTime) {
        //     $in = $workTime->in_time;
        //     $out = $workTime->out_time ?? now();

        //     $startOfMonth = CarbonImmutable::create($this->year, $this->month, 1, 0, 0, 0);
        //     $endOfMonth = $startOfMonth->endOfMonth()->setTime(23, 59, 59);

        //     $periodStart = $in->greaterThan($startOfMonth) ? $in : $startOfMonth;
        //     $periodEnd = $out->lessThan($endOfMonth) ? $out : $endOfMonth;

        //     if ($periodEnd->greaterThan($periodStart)) {
        //         $workMinutes = (int) round($periodStart->diffInSeconds($periodEnd) / 60);

        //         // この勤務に重なる休憩時間を引く
        //         foreach ($breakTimes as $breakTime) {
        //             $bStart = $breakTime->in_time;
        //             $bEnd = $breakTime->out_time ?? now();

        //             // 休憩時間も月に収まるように調整
        //             $bStart = $bStart->greaterThan($startOfMonth) ? $bStart : $startOfMonth;
        //             $bEnd = $bEnd->lessThan($endOfMonth) ? $bEnd : $endOfMonth;

        //             // 勤務時間と休憩時間の重なり
        //             $overlapStart = $periodStart->greaterThan($bStart) ? $periodStart : $bStart;
        //             $overlapEnd = $periodEnd->lessThan($bEnd) ? $periodEnd : $bEnd;

        //             if ($overlapEnd->greaterThan($overlapStart)) {
        //                 $workMinutes -= (int) round($overlapStart->diffInSeconds($overlapEnd) / 60);
        //             }
        //         }

        //         $totalMinutes += max($workMinutes, 0); // 負の値にならないように
        //     }
        // }

        // $hours = intdiv($totalMinutes, 60);
        // $minutes = $totalMinutes % 60;

        $totalMonthWorkingTime = totalWorkingTimeDto::month($this->user, $this->selectDate);

        return $totalMonthWorkingTime;
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.index');
    }
}
