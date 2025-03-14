<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Timecard\Livewire\Dto\totalWorkingTimeDto;
use Modules\Timecard\Livewire\Forms\BreakTimeData;
use Modules\Timecard\Livewire\Forms\BreakTimeForm;
use Modules\Timecard\Livewire\Forms\WorkTimeData;
use Modules\Timecard\Livewire\Forms\WorkTimeForm;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\WorkTime;

class Calendar extends Component
{
    #[Url(as: 'year')]
    public int $year;

    #[Url(as: 'month')]
    public int $month;

    public $totalWorkingTime;

    public CarbonImmutable $selectedDate;

    public WorkTimeForm $workTimeForm;

    public BreakTimeForm $breakTimeForm;

    public WorkTimeData $workData;

    public BreakTimeData $breakData;

    // TODO ダイアログが閉じない
    public bool $showDialog = false;

    public function mount(): void
    {
        $this->clickDate(CarbonImmutable::now());

        $this->totalWorkingTime = totalWorkingTimeDto::month(Auth::user(), $this->selectedDate);
    }

    public function clickDate($date): void
    {
        $this->selectedDate = CarbonImmutable::parse($date);
        $this->year = $this->selectedDate->year;
        $this->month = $this->selectedDate->month;

        $this->setWorkTimeList($this->selectedDate);
        $this->setBreakTimeList($this->selectedDate);

    }

    public function setWorkTimeList(CarbonImmutable $date)
    {
        $times = WorkTime::where('user_id', Auth::id())
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
        $times = BreakTime::where('user_id', Auth::id())
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
        $this->workData->userId = Auth::id();
        $this->workData->date = $this->selectedDate;
        $this->workData->save();

        $this->workData->reset(['date', 'inTime', 'outTime']);
        $this->reset('showDialog');

        $this->setWorkTimeList($this->selectedDate);
    }

    public function storeBreakTime()
    {
        $this->breakData->userId = Auth::id();
        $this->breakData->date = $this->selectedDate;
        $this->breakData->save();

        $this->breakData->reset(['date', 'inTime', 'outTime']);
        $this->reset('showDialog');

        $this->setBreakTimeList($this->selectedDate);
    }

    public function deleteWorkTime()
    {
        $this->workData->delete();
        $this->workData->reset(['date', 'inTime', 'outTime']);
        $this->reset('showDialog');
        $this->setWorkTimeList($this->selectedDate);
    }

    public function deleteBreakTime()
    {
        $this->breakData->delete();
        $this->breakData->reset(['date', 'inTime', 'outTime']);
        $this->reset('showDialog');
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
            'user_id' => Auth::id(),
        ]);
    }

    #[Computed()] #[On('refreshCalendar')]
    public function calendar()
    {
        $workTimes = WorkTime::where('user_id', Auth::id())
            ->whereYear('date', $this->selectedDate->year)
            ->whereMonth('date', $this->selectedDate->month)
            ->orderBy('in_time', 'asc')
            ->get()
            ->groupBy(fn ($attendance) => $attendance->date->toDateString());

        $breakTimes = BreakTime::where('user_id', Auth::id())
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
        return view('timecard::livewire.calendar.index');
    }
}
