<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Timecard\Livewire\General\Dto\totalWorkingTimeDto;
use Modules\Timecard\Support\WorkdayBoundary;

class TimecardCalendar extends Component
{
    use WithPagination;

    #[Url(as: 'user_id')]
    public ?int $selectedId = null;

    public ?User $user;

    public $year;

    public $month;

    public $day;

    #[Url(as: 'date')]
    public $selectDate;

    public function mount()
    {
        $this->user = Auth::user();
        $this->selectedId = $this->user->id;

        $this->selectDate = WorkdayBoundary::businessDate(CarbonImmutable::now());
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

    public function today()
    {
        $today = WorkdayBoundary::businessDate(CarbonImmutable::now());
        $this->year = $today->year;
        $this->month = $today->month;
        $this->day = $today->day;

        $this->changeDate();
    }

    public function changeDate()
    {
        $this->selectDate = CarbonImmutable::create($this->year, $this->month, $this->day);
    }

    public function selectUser(int $id)
    {
        $this->selectedId = $id;
        $this->user =
            $this->users
                ->where('id', $id)
                ->first();
    }

    public function getWorkTimeList($user)
    {
        $day = CarbonImmutable::parse($this->selectDate);
        $start = WorkdayBoundary::startOfDate($day);
        $end = WorkdayBoundary::endOfDate($day);

        return $user->workTime()
            ->where('in_time', '<', $end)
            ->where('out_time', '>', $start)
            ->get();
    }

    public function getBreakTimeList($user)
    {
        $day = CarbonImmutable::parse($this->selectDate);
        $start = WorkdayBoundary::startOfDate($day);
        $end = WorkdayBoundary::endOfDate($day);

        return $user->breakTime()
            ->where('in_time', '<', $end)
            ->where('out_time', '>', $start)
            ->get();
    }

    public function totalWorkTime()
    {
        $totalMonthWorkingTime = totalWorkingTimeDto::month($this->user, $this->selectDate);

        return $totalMonthWorkingTime;
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.index');
    }
}
