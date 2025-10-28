<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\Shift\Models\Schedule;
use Modules\Timecard\Livewire\General\Dto\totalWorkingTimeDto;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\WorkTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AttendanceRecoardShow extends Component
{
    public CarbonImmutable $date;

    public array $selectUsers = [];

    #[Url]
    public ?string $startDate;

    #[Url]
    public ?string $endDate;

    public function mount()
    {
        $this->startDate ??= CarbonImmutable::now()->startOfMonth()->format('Y-m-d');
        $this->endDate ??= CarbonImmutable::now()->format('Y-m-d');
    }

    public function downloadExcel()
    {
        $this->validate([
            'selectUsers' => 'required|array|min:1',
        ]);

        $selectedUsers = User::whereIn('id', $this->selectUsers)->get();
        $workTimes = WorkTime::query()
            ->whereBetween('in_time', [$this->startDate, $this->endDate])
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->orderBy('in_time', 'asc')
            ->get();

        $breakTimes = BreakTime::query()
            ->whereBetween('in_time', [$this->startDate, $this->endDate])
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->orderBy('in_time', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet;

        foreach ($selectedUsers as $index => $user) {
            $worksheet = $index === 0
                ? $spreadsheet->getActiveSheet()
                : $spreadsheet->createSheet();

            $worksheet->setTitle($user->name);

            // ヘッダー
            $worksheet->fromArray([['勤務日', '出勤', '退勤', '休憩開始', '休憩終了']], null, 'A1');

            $userWorkTimes = [];

            foreach ($workTimes->where('user_id', $user->id) as $workTime) {
                $start = $workTime->in_time->copy();
                $end = $workTime->out_time->copy();

                // 勤務を日ごとに分割
                while ($start->lt($end)) {
                    $currentDayEnd = $start->copy()->endOfDay();
                    $rowEnd = $end->lt($currentDayEnd) ? $end : $currentDayEnd;

                    // 当日の休憩を取得
                    $dailyBreaks = $breakTimes->where('user_id', $user->id)->filter(function ($b) use ($start, $rowEnd) {
                        return $b->in_time->lt($rowEnd) && $b->out_time->gt($start);
                    });

                    if ($dailyBreaks->isEmpty()) {
                        // 休憩なし
                        $userWorkTimes[] = [
                            $start->format('Y-m-d'),
                            $start->format('H:i'),
                            $rowEnd->format('H:i'),
                            '',
                            '',
                        ];
                    } else {
                        // 休憩がある場合は複数行に分ける
                        foreach ($dailyBreaks as $b) {
                            $breakStart = $b->in_time->lt($start) ? $start : $b->in_time;
                            $breakEnd = $b->out_time->gt($rowEnd) ? $rowEnd : $b->out_time;

                            $userWorkTimes[] = [
                                $start->format('Y-m-d'),
                                $start->format('H:i'),
                                $rowEnd->format('H:i'),
                                $breakStart->format('H:i'),
                                $breakEnd->format('H:i'),
                            ];
                        }
                    }

                    // 次の日に進める
                    $start = $rowEnd->copy()->addSecond();
                }
            }

            $worksheet->fromArray($userWorkTimes, null, 'A2');
        }

        $fileName = '勤怠記録_' . $this->startDate . '~' . $this->endDate . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet): void {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName);
    }

    #[Computed]
    public function workingTime(int $userId): string
    {
        $user = User::find($userId);

        $totalMinutes = $this->calcTotalMinutes(
            $user, CarbonPeriodImmutable::create($this->startDate, $this->endDate)
        );

        $totalWorkHoursFormatted = floor($totalMinutes / 60) . '時間' . ($totalMinutes % 60) . '分';

        return $totalWorkHoursFormatted;
    }

    #[Computed]
    public function getTotalPay(int $userId): string
    {
        $totalPay = totalWorkingTimeDto::selectDatePay(
            User::find($userId),
            CarbonImmutable::parse($this->startDate),
            CarbonImmutable::parse($this->endDate)->addDay()->subSecond()
        );

        return $totalPay;
    }

    private function calcTotalMinutes(User $user, CarbonPeriodImmutable $period)
    {
        // 既存のまま、休憩を引いた通常勤務分を返す
        $workTimes = WorkTime::query()
            ->where('user_id', $user->id)
            ->whereBetween('in_time', [$period->first()->startOfDay(), $period->last()->endOfDay()])
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->with('breakTimes')
            ->get();

        $totalMinutes = 0;

        foreach ($workTimes as $workTime) {
            $in = $workTime->in_time;
            $out = $workTime->out_time;

            $workMinutes = $in->diffInMinutes($out);

            $breakMinutes = $workTime->breakTimes->sum(fn ($break) => $break->in_time->diffInMinutes($break->out_time));

            $totalMinutes += max($workMinutes - $breakMinutes, 0);
        }

        return $totalMinutes;
    }

    #[Computed]
    public function prospectHourlyRate(int $userId): string
    {
        $user = User::find($userId);

        $startDate = CarbonImmutable::parse($this->startDate);
        $endDate = CarbonImmutable::parse($this->endDate)->addDay()->subSecond();

        $hourlyRateList = $user
            ->hourlyRate()
            ->whereBetween('effective_date', [$startDate, $endDate])
            ->get();

        if ($user->hourlyRate->isEmpty()) {
            return '--';
        }

        $hourlyRateTable = [];

        if ($startDate < $user->hourlyRate->first()->effective_date) {
            $hourlyRateTable[] = (object) [
                'rate' => 0,
                'start_date' => $startDate,
                'end_date' => $hourlyRateList->has(0) ? $hourlyRateList[0]->effective_date->subSecond() : $endDate,
            ];
        }
        foreach ($hourlyRateList as $key => $hourlyRate) {
            $hourlyRateTable[] = (object) [
                'rate' => $hourlyRate->rate,
                'start_date' => $hourlyRate->effective_date,
                'end_date' => $hourlyRateList->has($key + 1) ? $hourlyRateList[$key + 1]->effective_date->subSecond() : $endDate,
            ];
        }

        $totalPay = 0;

        foreach ($hourlyRateTable as $rateInfo) {
            $shiftSchedules = Schedule::query()
                ->where('user_id', $userId)
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->whereNotNull('start_time')
                ->whereNotNull('end_time')
                ->orderBy('start_time', 'asc')
                ->get();

            $minutes = $shiftSchedules->sum(function ($shiftSchedule) {
                $startTime = $shiftSchedule->start_time;
                $endTime = $shiftSchedule->end_time;

                return $startTime->diffInMinutes($endTime);
            });

            $totalPay += ($minutes / 60 * $rateInfo->rate);
        }

        return floor($totalPay) . '円';
    }

    #[Computed]
    public function users()
    {
        return User::orderBy('id', 'asc')->paginate(10);
    }

    public function render()
    {
        return view('timecard::admin.attendance.livewire.recoard-show');
    }
}
