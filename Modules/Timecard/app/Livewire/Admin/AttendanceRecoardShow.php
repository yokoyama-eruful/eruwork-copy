<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Exception;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Shift\Models\Schedule;
use Modules\Timecard\Livewire\General\Dto\totalWorkingTimeDto;
use Modules\Timecard\Services\WageCalculationService;
use Modules\Timecard\Services\TimecardServices;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AttendanceRecoardShow extends Component
{
    use WithPagination;

    public CarbonImmutable $date;

    #[Url(history: true)]
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

    public function updated($property)
    {
        if ($this->startDate && $this->endDate) {
            $start = CarbonImmutable::parse($this->startDate);
            $end = CarbonImmutable::parse($this->endDate);

            if ($start->gt($end)) {
                if ($property === 'startDate') {
                    $this->endDate = $this->startDate;
                } else {
                    $this->startDate = $this->endDate;
                }
            }
        }
    }

    public function downloadExcel()
    {
        try {
            $this->validate([
                'selectUsers' => 'required|array|min:1',
            ]);
            $service = app(TimecardServices::class);

            $selectedUsers = User::whereIn('id', $this->selectUsers)
                ->orderBy('id')
                ->get();

            $spreadsheet = new Spreadsheet;

            foreach ($selectedUsers as $index => $user) {
                $worksheet = $index === 0
                    ? $spreadsheet->getActiveSheet()
                    : $spreadsheet->createSheet();

                $worksheet->setTitle($user->name);
                $includeHolidayColumns = $user->profile?->contract_type !== 'アルバイト';
                $worksheet->fromArray([$this->excelHeaders($includeHolidayColumns)], null, 'A1');

                $userRows = $service->getTimecardDataList($this->startDate, $this->endDate, $user->id);
                $excelRows = array_map(function (array $row): array {
                    return [
                        $row['attendanceStartDate'],
                        $row['attendanceEndDate'],
                        $row['attendanceStartTime'],
                        $row['attendanceEndTime'],
                        $row['defaultWorkTime'],
                        $row['overTime'],
                        $row['overTimeOver60'],
                        $row['lateNightTime'],
                        $row['lateNightOverTime'],
                        $row['lateNightOverTimeOver60'],
                        $row['defaultBreakTime'],
                        $row['lateNightBreakTime'],
                    ];
                }, $userRows);
                if ($includeHolidayColumns) {
                    $excelRows = array_map(function (array $row): array {
                        return [
                            $row['attendanceStartDate'],
                            $row['attendanceEndDate'],
                            $row['attendanceStartTime'],
                            $row['attendanceEndTime'],
                            $row['defaultWorkTime'],
                            $row['overTime'],
                            $row['overTimeOver60'],
                            $row['lateNightTime'],
                            $row['lateNightOverTime'],
                            $row['lateNightOverTimeOver60'],
                            $row['holidayWorkTime'],
                            $row['holidayLateNightWorkTime'],
                            $row['defaultBreakTime'],
                            $row['lateNightBreakTime'],
                        ];
                    }, $userRows);
                }

                $worksheet->fromArray($excelRows, null, 'A2');

                $summaryRow = [
                    '合計',
                    '',
                    '',
                    '',
                    $this->sumFormattedTime($userRows, 'defaultWorkTime'),
                    $this->sumFormattedTime($userRows, 'overTime'),
                    $this->sumFormattedTime($userRows, 'overTimeOver60'),
                    $this->sumFormattedTime($userRows, 'lateNightTime'),
                    $this->sumFormattedTime($userRows, 'lateNightOverTime'),
                    $this->sumFormattedTime($userRows, 'lateNightOverTimeOver60'),
                    $this->sumFormattedTime($userRows, 'defaultBreakTime'),
                    $this->sumFormattedTime($userRows, 'lateNightBreakTime'),
                ];
                if ($includeHolidayColumns) {
                    $summaryRow = [
                        '合計',
                        '',
                        '',
                        '',
                        $this->sumFormattedTime($userRows, 'defaultWorkTime'),
                        $this->sumFormattedTime($userRows, 'overTime'),
                        $this->sumFormattedTime($userRows, 'overTimeOver60'),
                        $this->sumFormattedTime($userRows, 'lateNightTime'),
                        $this->sumFormattedTime($userRows, 'lateNightOverTime'),
                        $this->sumFormattedTime($userRows, 'lateNightOverTimeOver60'),
                        $this->sumFormattedTime($userRows, 'holidayWorkTime'),
                        $this->sumFormattedTime($userRows, 'holidayLateNightWorkTime'),
                        $this->sumFormattedTime($userRows, 'defaultBreakTime'),
                        $this->sumFormattedTime($userRows, 'lateNightBreakTime'),
                    ];
                }

                $summaryRowNumber = count($excelRows) + 2;
                $worksheet->fromArray([$summaryRow], null, 'A' . $summaryRowNumber);
            }

            $fileName = '勤怠記録_' . $this->startDate . '~' . $this->endDate . '.xlsx';

            return response()->streamDownload(function () use ($spreadsheet): void {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }, $fileName);
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    private function excelHeaders(bool $includeHolidayColumns): array
    {
        $headers = [
            '勤務日',
            '退勤日',
            '出勤',
            '退勤',
            '通常勤務',
            '残業(60hまで)',
            '残業(60h超)',
            '深夜',
            '残業+深夜(60hまで)',
            '残業+深夜(60h超)',
        ];

        if ($includeHolidayColumns) {
            $headers[] = '休日';
            $headers[] = '休日+深夜';
        }

        $headers[] = '通常休憩';
        $headers[] = '深夜休憩';

        return $headers;
    }

    private function sumFormattedTime(array $rows, string $key): string
    {
        $totalMinutes = 0;

        foreach ($rows as $row) {
            $totalMinutes += $this->formattedTimeToMinutes((string) ($row[$key] ?? '0:00'));
        }

        return sprintf('%d:%02d', intdiv($totalMinutes, 60), $totalMinutes % 60);
    }

    private function formattedTimeToMinutes(string $value): int
    {
        [$hours, $minutes] = array_pad(explode(':', $value), 2, '0');

        return ((int) $hours * 60) + (int) $minutes;
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
        /** @var WageCalculationService $service */
        $service = app(WageCalculationService::class);
        $summary = $service->summarize($user, $period->first(), $period->last());

        return array_sum($summary['minutes']);
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

    // AttendanceRecoardShow.php

    public function toggleSelectAll()
    {
        // 1. システム上の全ユーザーIDを文字列配列で取得（ページネーションに関係なく全員）
        $allUserIds = User::pluck('id')->map(fn ($id) => (string) $id)->toArray();

        // 2. 現在の選択状態を取得
        $currentSelected = collect($this->selectUsers)->map(fn ($id) => (string) $id)->toArray();

        // 3. 全員がすでに選択されているか判定
        if (count($allUserIds) > 0 && count($allUserIds) === count($currentSelected)) {
            // 全員選択済みなら、空にする（全解除）
            $this->selectUsers = [];
        } else {
            // 全員を選択状態にする
            $this->selectUsers = $allUserIds;
        }
    }

    public function render()
    {
        return view('timecard::admin.attendance.livewire.recoard-show');
    }
}
