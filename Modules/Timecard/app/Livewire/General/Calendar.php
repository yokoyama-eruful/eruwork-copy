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

    public int $selectUserId;

    public $workTimeList;

    public $breakTimeList;

    public function mount(): void
    {
        $this->selectUserId = (int) Auth::id();

        // URLパラメータがない場合は現在時刻、ある場合はその年月で初期化
        $initialDate = ($this->year && $this->month)
            ? CarbonImmutable::create($this->year, $this->month, 1)
            : CarbonImmutable::now();

        $this->refreshAllData($initialDate);
    }

    /**
     * 日付クリック時の処理
     * 同一月内の移動であれば重い集計（年計など）をスキップする
     */
    public function clickDate($date): void
    {
        $newDate = CarbonImmutable::parse($date);
        $isMonthChanged = ($this->year !== $newDate->year || $this->month !== $newDate->month);

        $this->selectedDate = $newDate;
        $this->year = $newDate->year;
        $this->month = $newDate->month;

        $this->startDate = $this->selectedDate->startOfMonth();
        $this->endDate = $this->selectedDate->endOfMonth();

        // 1日の詳細リスト更新
        $this->setWorkTimeList($this->selectedDate);
        $this->setBreakTimeList($this->selectedDate);

        // 月をまたぐ移動の場合のみ、重い集計を再実行
        if ($isMonthChanged) {
            $this->calculateSummaries();
        }
    }

    /**
     * セレクトボックス等で年月が変更された際の処理
     */
    public function updateCalendar(): void
    {
        // 選択されている「日」を維持しつつ年月を更新（存在しない日はCarbonが自動調整）
        $newDate = CarbonImmutable::create($this->year, $this->month, $this->selectedDate->day ?? 1);
        $this->refreshAllData($newDate);
    }

    /**
     * 前月・翌月・今月ボタン等の処理
     */
    public function selectedMonth(string $date): void
    {
        $this->refreshAllData(CarbonImmutable::parse($date));
    }

    /**
     * 指定された日付に基づき、すべてのデータをリフレッシュする（重い処理）
     */
    private function refreshAllData(CarbonImmutable $date): void
    {
        $this->selectedDate = $date;
        $this->year = $date->year;
        $this->month = $date->month;
        $this->startDate = $date->startOfMonth();
        $this->endDate = $date->endOfMonth();

        $this->setWorkTimeList($date);
        $this->setBreakTimeList($date);
        $this->calculateSummaries();
    }

    /**
     * DTOを使用した集計処理（ボトルネック箇所）
     */
    private function calculateSummaries(): void
    {
        $selectUser = Auth::user(); // User::findを節約

        // 月間・年間の集計を一括で行う
        $this->totalMonthWorkingTime = totalWorkingTimeDto::month($selectUser, $this->selectedDate);
        $this->totalYearWorkingTime = totalWorkingTimeDto::year($selectUser, $this->selectedDate);
        $this->totalYearPay = totalWorkingTimeDto::yearPay($selectUser, $this->selectedDate);
    }

    public function setWorkTimeList(CarbonImmutable $date): void
    {
        $this->workTimeList = WorkTime::where('user_id', $this->selectUserId)
            ->whereDate('in_time', $date)
            ->orderBy('in_time', 'asc')
            ->get();

        $this->workTimeForm->setWorkTimes($this->workData, $this->workTimeList);
    }

    public function setBreakTimeList(CarbonImmutable $date): void
    {
        $workTimeIds = $this->workTimeList->pluck('id');

        $this->breakTimeList = BreakTime::where('user_id', $this->selectUserId)
            ->whereIn('timecard__work_time_id', $workTimeIds)
            ->orderBy('in_time', 'asc')
            ->get();

        $this->breakTimeForm->setBreakTimes($this->breakData, $this->breakTimeList);
    }

    #[Computed()] #[On('refreshCalendar')]
    public function calendar()
    {
        // カレンダー表示範囲（前後の補助日を含む）を取得
        $periodStart = $this->selectedDate->startOfMonth()->startOfWeek(CarbonImmutable::MONDAY);
        $periodEnd = $this->selectedDate->endOfMonth()->endOfWeek(CarbonImmutable::SUNDAY);

        // クエリ範囲をカレンダー全域に広げる（補助日のデータも表示するため）
        $workTimesGrouped = WorkTime::where('user_id', $this->selectUserId)
            ->where(function ($q) use ($periodStart, $periodEnd) {
                $q->whereBetween('in_time', [$periodStart, $periodEnd])
                    ->orWhereBetween('out_time', [$periodStart, $periodEnd]);
            })
            ->orderBy('in_time', 'asc')
            ->get()
            ->groupBy(fn ($work) => $work->in_time->toDateString());

        $breakTimesGrouped = BreakTime::where('user_id', $this->selectUserId)
            ->whereIn('timecard__work_time_id', $workTimesGrouped->flatten()->pluck('id'))
            ->orderBy('in_time', 'asc')
            ->get()
            ->groupBy('timecard__work_time_id');

        $period = CarbonPeriodImmutable::create($periodStart, $periodEnd);

        return iterator_to_array($period->map(function ($date) use ($workTimesGrouped, $breakTimesGrouped) {
            $dateString = $date->toDateString();
            $workTimeRecords = $workTimesGrouped->get($dateString, collect());
            $breakTimeRecords = $workTimeRecords->flatMap(fn ($work) => $breakTimesGrouped->get($work->id, collect()));

            return [
                'date' => $date,
                'type' => $this->getDayType($date),
                'workTimes' => $workTimeRecords,
                'breakTimes' => $breakTimeRecords,
            ];
        }));
    }

    private function getDayType(CarbonImmutable $date): string
    {
        if ($date->month !== $this->month) {
            return '補助日';
        }

        return match ($date->dayOfWeek) {
            CarbonImmutable::SATURDAY => '土曜日',
            CarbonImmutable::SUNDAY => '日曜日',
            default => '平日',
        };
    }

    #[Computed()]
    public function barWidth(): string
    {
        $barWidthLimit = 1750000;
        $pay = (float) ($this->totalYearPay ?? 0);

        return min($pay / $barWidthLimit, 1) * 100 . '%';
    }

    public function save(): void
    {
        $this->workTimeForm->sync();
        $this->breakTimeForm->sync();
        $this->refreshAllData($this->selectedDate);
    }

    public function render()
    {
        return view('timecard::general.livewire.calendar.index');
    }
}
