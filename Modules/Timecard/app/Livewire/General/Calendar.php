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

    public $totalWorkingTime;

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

    public function mount(): void
    {
        $this->users = User::get();

        $this->selectUserId = Auth::id();

        $selectUser = User::find($this->selectUserId);

        $this->clickDate(CarbonImmutable::now());

        $this->totalWorkingTime = totalWorkingTimeDto::month($selectUser, $this->selectedDate);
    }

    public function changeSelectUser()
    {

        $selectUser = User::find($this->selectUserId);

        $this->clickDate(CarbonImmutable::now());

        $this->totalWorkingTime = totalWorkingTimeDto::month($selectUser, $this->selectedDate);

        $this->dispatch('refreshCalendar');
    }

    public function clickDate($date): void
    {
        $this->selectedDate = CarbonImmutable::parse($date);
        $this->startDate = CarbonImmutable::parse($date)->startOfMonth();
        $this->endDate = CarbonImmutable::parse($date)->endOfMonth();

        $this->year = $this->selectedDate->year;
        $this->month = $this->selectedDate->month;

        $this->setWorkTimeList($this->selectedDate);
        $this->setBreakTimeList($this->selectedDate);
    }

    public function setWorkTimeList(CarbonImmutable $date)
    {
        $times = WorkTime::where('user_id', $this->selectUserId)
            ->where('date', $date)
            ->orderBy('in_time', 'asc')
            ->get();

        $this->workTimeForm->setWorkTimes($this->workData, $times);
    }

    public function setWorkTime(?int $id)
    {
        if (is_null($id)) {
            $this->workData->reset(['inTime', 'outTime']);

            return;
        }

        $workTime = WorkTime::find($id);

        $this->workData->setData($workTime);
    }

    public function addWorkTime()
    {
        $this->workTimeForm->addWorkTime($this->workData, $this->selectedDate);
    }

    public function removeWorkTime($key)
    {
        $this->workTimeForm->removeWorkTime($key);
    }

    public function setBreakTimeList(CarbonImmutable $date)
    {
        $times = BreakTime::where('user_id', $this->selectUserId)
            ->where('date', $date)
            ->orderBy('in_time', 'asc')
            ->get();

        $this->breakTimeForm->setBreakTimes($this->breakData, $times);
    }

    public function setBreakTime(?int $id)
    {
        if (is_null($id)) {
            $this->breakData->reset(['inTime', 'outTime']);

            return;
        }

        $breakTime = BreakTime::find($id);

        $this->breakData->setData($breakTime);
    }

    public function addBreakTime()
    {
        $this->breakTimeForm->addBreakTime($this->breakData, $this->selectedDate);
    }

    public function removeBreakTime($key)
    {
        $this->breakTimeForm->removeBreakTime($key);
    }

    public function storeWorkTime()
    {
        $this->workData->userId = $this->selectUserId;
        $this->workData->date = $this->selectedDate;
        $this->workData->save();

        $this->workData->reset(['id', 'userId', 'date', 'inTime', 'outTime']);
        $this->dispatch('close-modal', 'work-time-modal');

        $this->setWorkTimeList($this->selectedDate);
    }

    public function storeBreakTime()
    {
        $this->breakData->userId = $this->selectUserId;
        $this->breakData->date = $this->selectedDate;
        $this->breakData->save();

        $this->breakData->reset(['id', 'userId', 'date', 'inTime', 'outTime']);
        $this->dispatch('close-modal', 'break-time-modal');

        $this->setBreakTimeList($this->selectedDate);
    }

    public function deleteWorkTime()
    {
        $this->workData->delete();
        $this->dispatch('close-modal', 'work-time-modal');
        $this->setWorkTimeList($this->selectedDate);
    }

    public function deleteBreakTime()
    {
        $this->breakData->delete();
        $this->dispatch('close-modal', 'break-time-modal');
        $this->setBreakTimeList($this->selectedDate);
    }

    public function updateCalendar()
    {
        $this->selectedDate =
            CarbonImmutable::create($this->year, $this->month, $this->selectedDate->day);
    }

    public function selectedMonth(string $date)
    {
        $this->selectedDate = CarbonImmutable::parse($date);
        $this->year = $this->selectedDate->year;
        $this->month = $this->selectedDate->month;
    }

    public function createBreakTime()
    {
        BreakTime::create([
            'date' => $this->selectedDate,
            'user_id' => $this->selectUserId,
        ]);
    }

    #[Computed()] #[On('refreshCalendar')]
    public function calendar()
    {
        $workTimes = WorkTime::where('user_id', $this->selectUserId)
            ->whereYear('date', $this->selectedDate->year)
            ->whereMonth('date', $this->selectedDate->month)
            ->orderBy('in_time', 'asc')
            ->get()
            ->groupBy(fn ($attendance) => $attendance->date->toDateString());

        $breakTimes = BreakTime::where('user_id', $this->selectUserId)
            ->whereYear('date', $this->selectedDate->year)
            ->whereMonth('date', $this->selectedDate->month)
            ->get()
            ->groupBy(fn ($breakTime) => $breakTime->date->toDateString());

        $period = CarbonPeriodImmutable::create(
            $this->selectedDate->startOfMonth()->startOfWeek(CarbonImmutable::MONDAY),
            $this->selectedDate->endOfMonth()->endOfWeek(CarbonImmutable::SUNDAY)
        );

        return $period->map(function ($date) use ($workTimes, $breakTimes) {
            $type = $this->getDayType($date);

            $workTimeRecords = $workTimes->get($date->toDateString(), collect());
            $breakTimeRecords = $breakTimes->get($date->toDateString(), collect());

            return [
                'date' => $date,
                'type' => $type,
                'workTimes' => $workTimeRecords,
                'breakTimes' => $breakTimeRecords,
            ];
        });
    }

    private function getDayType(CarbonImmutable $date): string
    {
        if ($date->format('m') !== $this->selectedDate->format('m')) {
            return '補助日';
        }

        // if ($holidays->where('date', $date)->isNotEmpty()) {
        //     return '公休日';
        // }

        return match ($date->dayOfWeek) {
            CarbonImmutable::SATURDAY => '土曜日',
            CarbonImmutable::SUNDAY => '日曜日',
            default => '平日',
        };
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
