<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\General;

use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Timecard\Livewire\General\Dto\totalWorkingTimeDto;
use Modules\Timecard\Livewire\General\Forms\BreakTimeData;
use Modules\Timecard\Livewire\General\Forms\BreakTimeForm;
use Modules\Timecard\Livewire\General\Forms\WorkTimeData;
use Modules\Timecard\Livewire\General\Forms\WorkTimeForm;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\WorkTime;

class Calendar extends Component
{
    #[Url(as: 'year')]
    public int $year;

    #[Url(as: 'month')]
    public int $month;

    public $totalMonthWorkingTime;

    public $totalYearWorkingTime;

    public $totalYearPay;

    #[Url(as: 'startDate')]
    public $startDate;

    #[Url(as: 'endDate')]
    public $endDate;

    public CarbonImmutable $selectedDate;

    public WorkTimeForm $workTimeForm;

    public BreakTimeForm $breakTimeForm;

    public WorkTimeData $workData;

    public BreakTimeData $breakData;

    public $users;

    public int $selectUserId;

    public $workTimeList;

    public $breakTimeList;

    public function mount(): void
    {
        $this->users = User::get();
        $this->selectUserId = Auth::id();

        $this->clickDate(CarbonImmutable::now());
    }

    public function clickDate($date): void
    {
        $this->selectedDate = CarbonImmutable::parse($date);
        $this->startDate = $this->selectedDate->startOfMonth();
        $this->endDate = $this->selectedDate->endOfMonth();

        $this->year = $this->selectedDate->year;
        $this->month = $this->selectedDate->month;

        $this->setWorkTimeList($this->selectedDate);
        $this->setBreakTimeList($this->selectedDate);

        $selectUser = User::find($this->selectUserId);

        $this->totalMonthWorkingTime = totalWorkingTimeDto::month($selectUser, $this->selectedDate);
        $this->totalYearWorkingTime = totalWorkingTimeDto::year($selectUser, $this->selectedDate);
        $this->totalYearPay = totalWorkingTimeDto::yearPay($selectUser, $this->selectedDate);
    }

    public function setWorkTimeList(CarbonImmutable $date)
    {
        $this->workTimeList = WorkTime::where('user_id', $this->selectUserId)
            ->whereDate('in_time', $date)
            ->orderBy('in_time', 'asc')
            ->get();

        $this->workTimeForm->setWorkTimes($this->workData, $this->workTimeList);
    }

    public function setBreakTimeList(CarbonImmutable $date)
    {
        // まず、その日の勤務IDを取得
        $workTimeIds = $this->workTimeList->pluck('id');

        $this->breakTimeList = BreakTime::where('user_id', $this->selectUserId)
            ->whereIn('timecard__work_time_id', $workTimeIds)
            ->orderBy('in_time', 'asc')
            ->get();

        $this->breakTimeForm->setBreakTimes($this->breakData, $this->breakTimeList);
    }

    public function updateCalendar()
    {
        $this->selectedDate =
            CarbonImmutable::create($this->year, $this->month, $this->selectedDate->day);

        $selectUser = User::find($this->selectUserId);

        $this->totalMonthWorkingTime = totalWorkingTimeDto::month($selectUser, $this->selectedDate);

        $this->totalYearWorkingTime = totalWorkingTimeDto::year($selectUser, $this->selectedDate);

        $this->totalYearPay = totalWorkingTimeDto::yearPay($selectUser, $this->selectedDate);
    }

    public function selectedMonth(string $date)
    {
        $this->selectedDate = CarbonImmutable::parse($date);
        $this->year = $this->selectedDate->year;
        $this->month = $this->selectedDate->month;

        $selectUser = User::find($this->selectUserId);

        $this->totalMonthWorkingTime = totalWorkingTimeDto::month($selectUser, $this->selectedDate);

        $this->totalYearWorkingTime = totalWorkingTimeDto::year($selectUser, $this->selectedDate);

        $this->totalYearPay = totalWorkingTimeDto::yearPay($selectUser, $this->selectedDate);
    }

    #[Computed()] #[On('refreshCalendar')]
    public function calendar()
    {
        $workTimes = WorkTime::where('user_id', $this->selectUserId)
            ->where(function ($q) {
                $q->whereBetween('in_time', [$this->startDate, $this->endDate])
                    ->orWhereBetween('out_time', [$this->startDate, $this->endDate])
                    ->orWhere(function ($q2) {
                        $q2->where('in_time', '<', $this->startDate)
                            ->where('out_time', '>', $this->endDate);
                    });
            })
            ->orderBy('in_time', 'asc')
            ->get();

        $breakTimes = BreakTime::where('user_id', $this->selectUserId)
            ->whereNotNull('timecard__work_time_id') // 勤務に紐づくものだけ
            ->whereIn('timecard__work_time_id', $workTimes->pluck('id'))
            ->orderBy('in_time', 'asc')
            ->get();

        $period = CarbonPeriodImmutable::create(
            $this->selectedDate->startOfMonth()->startOfWeek(CarbonImmutable::MONDAY),
            $this->selectedDate->endOfMonth()->endOfWeek(CarbonImmutable::SUNDAY)
        );

        return iterator_to_array($period->map(function ($date) use ($workTimes, $breakTimes) {
            $type = $this->getDayType($date);

            // 勤務は in_time の日付でのみ表示
            $workTimeRecords = $workTimes->filter(function ($work) use ($date) {
                return $work->in_time->toDateString() === $date->toDateString();
            });

            // その勤務に紐づく休憩だけ取得
            $breakTimeRecords = collect();
            foreach ($workTimeRecords as $work) {
                $breakTimeRecords = $breakTimeRecords->merge(
                    $breakTimes->where('timecard__work_time_id', $work->id)
                );
            }

            return [
                'date' => $date,
                'type' => $type,
                'workTimes' => $workTimeRecords,
                'breakTimes' => $breakTimeRecords,
            ];
        }));
    }

    private function getDayType(CarbonImmutable $date): string
    {
        if ($date->format('m') !== $this->selectedDate->format('m')) {
            return '補助日';
        }

        return match ($date->dayOfWeek) {
            CarbonImmutable::SATURDAY => '土曜日',
            CarbonImmutable::SUNDAY => '日曜日',
            default => '平日',
        };
    }

    public function barWidth()
    {
        $selectUser = User::find($this->selectUserId);

        $totalPay = totalWorkingTimeDto::yearPay($selectUser, $this->selectedDate);

        $barWidthLimit = 1750000;

        return min($totalPay / $barWidthLimit, 1) * 100 . '%';
    }

    public function save()
    {
        $this->workTimeForm->sync();
        $this->breakTimeForm->sync();
        $this->clickDate($this->selectedDate);
    }

    public function render()
    {
        return view('timecard::general.livewire.calendar.index');
    }
}
