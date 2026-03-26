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
use Modules\Timecard\Models\WagePremium;
use Modules\Timecard\Services\WageCalculationService;
use Modules\Timecard\Services\TimecardServices;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AttendanceRecoardShow extends Component
{
    use WithPagination;

    private const EXCEL_TEMPLATE_PATH = '勤怠管理ダウンロード雛形ver.1.xlsx';

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

            $spreadsheet = $this->loadTemplateSpreadsheet();
            $templateSheet = clone $spreadsheet->getActiveSheet();
            $usedTitles = [];
            $wageCalculationService = app(WageCalculationService::class);

            foreach ($selectedUsers as $index => $user) {
                $worksheet = $index === 0
                    ? $spreadsheet->getActiveSheet()
                    : clone $templateSheet;

                $worksheet->setTitle($this->uniqueSheetTitle($user->name, $usedTitles));

                if ($index > 0) {
                    $spreadsheet->addSheet($worksheet);
                }

                $userRows = $service->getTimecardDataList($this->startDate, $this->endDate, $user->id);
                $summary = $wageCalculationService->summarize(
                    $user,
                    CarbonImmutable::parse($this->startDate),
                    CarbonImmutable::parse($this->endDate)
                );

                $this->populateTemplateSheet($worksheet, $user, $userRows, $summary);
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

    private function populateTemplateSheet(Worksheet $worksheet, User $user, array $userRows, array $summary): void
    {
        $detailRows = array_map(fn (array $row): array => $this->templateDetailRow($row), $userRows);
        $requiredRows = max(count($detailRows), 14);
        $lastDataRow = 16;

        if ($requiredRows > 14) {
            $worksheet->insertNewRowBefore(17, $requiredRows - 14);
        }

        if ($detailRows !== []) {
            $worksheet->fromArray($detailRows, null, 'B3');
            $lastDataRow = count($detailRows) + 2;
            $worksheet->duplicateStyle($worksheet->getStyle('B3:L3'), 'B3:L' . $lastDataRow);

            for ($row = 3; $row <= $lastDataRow; $row++) {
                $worksheet->getRowDimension($row)->setRowHeight(30);
            }
        }

        $wagePremium = WagePremium::first();
        $displayedTimeTotals = $this->displayedTimeTotals($summary['minutes']);
        $displayedPayTotals = $this->displayedPayTotals($summary['payBuckets']);
        $thresholdTotals = $this->displayedThresholdTotals($summary['thresholds'] ?? []);

        $this->populateThresholdColumns($worksheet, $userRows, $lastDataRow);
        $this->populateThresholdSummary($worksheet, $thresholdTotals);
        $worksheet->setCellValue('N17', '');

        $worksheet->setCellValue('O4', $this->hourlyRateDisplay($user));
        $worksheet->setCellValue('O5', $this->rateToPercentValue($wagePremium?->night_rate, 25));
        $worksheet->setCellValue('O6', $this->rateToPercentValue($wagePremium?->overtime_rate, 25));
        $worksheet->setCellValue('R3', $displayedTimeTotals['regular']);
        $worksheet->setCellValue('R4', $displayedTimeTotals['night']);
        $worksheet->setCellValue('R5', $displayedTimeTotals['overtime']);
        $worksheet->setCellValue('R6', $displayedTimeTotals['overtimeNight']);
        $worksheet->setCellValue('R7', $displayedTimeTotals['total']);
        $worksheet->setCellValue('R10', $displayedPayTotals['regular']);
        $worksheet->setCellValue('R11', $displayedPayTotals['night']);
        $worksheet->setCellValue('R12', $displayedPayTotals['overtime']);
        $worksheet->setCellValue('R13', $displayedPayTotals['overtimeNight']);
        $worksheet->setCellValue('R14', number_format((int) ($summary['totalPay'] ?? 0)) . '円');
    }

    private function loadTemplateSpreadsheet(): Spreadsheet
    {
        $templatePath = base_path(self::EXCEL_TEMPLATE_PATH);

        if (is_file($templatePath)) {
            return IOFactory::load($templatePath);
        }

        $spreadsheet = new Spreadsheet;
        $this->initializeTemplateSheet($spreadsheet->getActiveSheet());

        return $spreadsheet;
    }

    private function initializeTemplateSheet(Worksheet $worksheet): void
    {
        $worksheet->setTitle('完成版');

        foreach ([
            'A' => 6,
            'B' => 18.86,
            'C' => 8.86,
            'D' => 13.86,
            'E' => 10.57,
            'F' => 8.86,
            'G' => 8.86,
            'H' => 8.86,
            'I' => 8.86,
            'J' => 8.86,
            'K' => 8.86,
            'L' => 12.86,
            'N' => 9.71,
            'O' => 8.71,
            'Q' => 20.29,
            'R' => 15.71,
        ] as $column => $width) {
            $worksheet->getColumnDimension($column)->setWidth($width);
        }

        foreach ([2, 3, 4, 5, 6, 7, 9, 10, 11, 12, 13, 14] as $row) {
            $worksheet->getRowDimension($row)->setRowHeight(30);
        }

        $worksheet->mergeCells('Q2:R2');
        $worksheet->mergeCells('Q9:R9');

        $worksheet->fromArray([[
            '勤務開始日', '出勤時刻', '勤務終了日', '退勤時刻',
            '通常時間', '深夜時間', '残業時間', '深夜残業', '深夜休憩', '通常休憩', '実働時間',
        ]], null, 'B2');

        $worksheet->fromArray([
            ['通常時間合計', ''],
            ['深夜時間合計', ''],
            ['残業時間合計', ''],
            ['深夜残業時間合計', ''],
            ['実働時間合計', ''],
        ], null, 'Q3');

        $worksheet->setCellValue('Q2', '時間合計');
        $worksheet->setCellValue('Q9', '金額合計');
        $worksheet->fromArray([
            ['通常時間金額', ''],
            ['深夜時間金額', ''],
            ['残業時間金額', ''],
            ['深夜残業時間金額', ''],
            ['支給金額合計', ''],
        ], null, 'Q10');

        $worksheet->fromArray([
            ['時給', ''],
            ['深夜割増', ''],
            ['残業割増', ''],
        ], null, 'N4');

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9EAF7'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];
        $boxStyle = [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        $worksheet->getStyle('B2:L2')->applyFromArray($headerStyle);
        $worksheet->getStyle('Q2:R2')->applyFromArray($headerStyle);
        $worksheet->getStyle('Q9:R9')->applyFromArray($headerStyle);
        $worksheet->getStyle('N4:O6')->applyFromArray($boxStyle);
        $worksheet->getStyle('Q3:R7')->applyFromArray($boxStyle);
        $worksheet->getStyle('Q10:R14')->applyFromArray($boxStyle);
        $worksheet->getStyle('B3:L16')->applyFromArray($boxStyle);
        $worksheet->getStyle('O5:O6')->getNumberFormat()->setFormatCode('0%');
        $worksheet->getStyle('O4')->getNumberFormat()->setFormatCode('#,##0');
    }

    private function templateDetailRow(array $row): array
    {
        return [
            $row['attendanceStartDate'],
            $row['attendanceStartTime'],
            $row['attendanceEndDate'],
            $row['attendanceEndTime'],
            $row['defaultWorkTime'],
            $row['lateNightTime'],
            $this->sumFormattedValues([
                $row['overTime'] ?? '0:00',
                $row['overTimeOver60'] ?? '0:00',
                $row['holidayWorkTime'] ?? '0:00',
            ]),
            $this->sumFormattedValues([
                $row['lateNightOverTime'] ?? '0:00',
                $row['lateNightOverTimeOver60'] ?? '0:00',
                $row['holidayLateNightWorkTime'] ?? '0:00',
            ]),
            $row['lateNightBreakTime'],
            $row['defaultBreakTime'],
            $this->sumFormattedValues([
                $row['defaultWorkTime'] ?? '0:00',
                $row['lateNightTime'] ?? '0:00',
                $row['overTime'] ?? '0:00',
                $row['overTimeOver60'] ?? '0:00',
                $row['lateNightOverTime'] ?? '0:00',
                $row['lateNightOverTimeOver60'] ?? '0:00',
                $row['holidayWorkTime'] ?? '0:00',
                $row['holidayLateNightWorkTime'] ?? '0:00',
            ]),
        ];
    }

    private function displayedTimeTotals(array $minutes): array
    {
        return [
            'regular' => $this->minutesToFormattedTime($minutes['regular'] ?? 0),
            'night' => $this->minutesToFormattedTime($minutes['night'] ?? 0),
            'overtime' => $this->minutesToFormattedTime(
                ($minutes['overtime'] ?? 0)
                + ($minutes['overtimeOver60'] ?? 0)
                + ($minutes['holiday'] ?? 0)
            ),
            'overtimeNight' => $this->minutesToFormattedTime(
                ($minutes['overtimeNight'] ?? 0)
                + ($minutes['overtimeOver60Night'] ?? 0)
                + ($minutes['holidayNight'] ?? 0)
            ),
            'total' => $this->minutesToFormattedTime(array_sum($minutes)),
        ];
    }

    private function displayedPayTotals(array $payBuckets): array
    {
        return [
            'regular' => $this->formatYen($payBuckets['regular'] ?? '0'),
            'night' => $this->formatYen($payBuckets['night'] ?? '0'),
            'overtime' => $this->formatYen($this->sumDecimalStrings([
                $payBuckets['overtime'] ?? '0',
                $payBuckets['overtimeOver60'] ?? '0',
                $payBuckets['holiday'] ?? '0',
            ])),
            'overtimeNight' => $this->formatYen($this->sumDecimalStrings([
                $payBuckets['overtimeNight'] ?? '0',
                $payBuckets['overtimeOver60Night'] ?? '0',
                $payBuckets['holidayNight'] ?? '0',
            ])),
        ];
    }

    private function displayedThresholdTotals(array $thresholds): array
    {
        return [
            'weeklyOver40' => $this->minutesToFormattedTime((int) ($thresholds['weeklyOver40'] ?? 0)),
            'monthlyOver60' => $this->minutesToFormattedTime((int) ($thresholds['monthlyOver60'] ?? 0)),
        ];
    }

    private function populateThresholdColumns(Worksheet $worksheet, array $userRows, int $lastDataRow): void
    {
        $worksheet->getColumnDimension('S')->setWidth(12);
        $worksheet->getColumnDimension('T')->setWidth(12);
        $worksheet->setCellValue('S2', '週40h超過');
        $worksheet->setCellValue('T2', '月60h超過');
        $worksheet->duplicateStyle($worksheet->getStyle('Q2:R2'), 'S2:T2');

        if ($lastDataRow >= 3) {
            $worksheet->duplicateStyle($worksheet->getStyle('Q3:R3'), 'S3:T' . $lastDataRow);
        }

        if ($userRows === []) {
            return;
        }

        $thresholdRows = array_map(function (array $row): array {
            return [
                $row['weeklyOver40'] ?? '',
                $row['monthlyOver60'] ?? '',
            ];
        }, $userRows);

        $worksheet->fromArray($thresholdRows, null, 'S3');
    }

    private function populateThresholdSummary(Worksheet $worksheet, array $thresholdTotals): void
    {
        $worksheet->getColumnDimension('V')->setWidth(16);
        $worksheet->getColumnDimension('W')->setWidth(12);
        $worksheet->setCellValue('V2', '超過合計');
        $worksheet->setCellValue('V3', '週40時間超');
        $worksheet->setCellValue('W3', $thresholdTotals['weeklyOver40']);
        $worksheet->setCellValue('V4', '月60時間超');
        $worksheet->setCellValue('W4', $thresholdTotals['monthlyOver60']);
        $worksheet->duplicateStyle($worksheet->getStyle('Q2:R2'), 'V2:W2');
        $worksheet->duplicateStyle($worksheet->getStyle('Q3:R3'), 'V3:W3');
        $worksheet->duplicateStyle($worksheet->getStyle('Q4:R4'), 'V4:W4');
    }

    private function formattedTimeToMinutes(string $value): int
    {
        [$hours, $minutes] = array_pad(explode(':', $value), 2, '0');

        return ((int) $hours * 60) + (int) $minutes;
    }

    private function sumFormattedValues(array $values): string
    {
        $totalMinutes = 0;

        foreach ($values as $value) {
            $totalMinutes += $this->formattedTimeToMinutes((string) $value);
        }

        return $this->minutesToFormattedTime($totalMinutes);
    }

    private function minutesToFormattedTime(int $minutes): string
    {
        return sprintf('%d:%02d', intdiv($minutes, 60), $minutes % 60);
    }

    private function formatYen(string $amount): string
    {
        return number_format((int) ceil((float) $amount)) . '円';
    }

    private function sumDecimalStrings(array $values): string
    {
        return array_reduce(
            $values,
            fn (string $carry, string $value): string => bcadd($carry, $value, 10),
            '0'
        );
    }

    private function rateToPercentValue(null|int|string|float $rate, int $default): float
    {
        return (($rate === null || $rate === '') ? $default : (float) $rate) / 100;
    }

    private function hourlyRateDisplay(User $user): int|string
    {
        $startDate = CarbonImmutable::parse($this->startDate)->startOfDay();
        $endDate = CarbonImmutable::parse($this->endDate)->endOfDay();
        $applicableRates = $user->hourlyRate()
            ->whereDate('effective_date', '<=', $endDate)
            ->orderBy('effective_date')
            ->get();

        if ($applicableRates->isEmpty()) {
            return '';
        }

        $rates = [];
        $currentRate = $applicableRates
            ->filter(fn ($hourlyRate) => $hourlyRate->effective_date->startOfDay()->lte($startDate))
            ->last();

        if ($currentRate) {
            $rates[] = (int) $currentRate->rate;
        }

        foreach ($applicableRates as $hourlyRate) {
            if ($hourlyRate->effective_date->betweenIncluded($startDate, $endDate)) {
                $rates[] = (int) $hourlyRate->rate;
            }
        }

        $uniqueRates = array_values(array_unique($rates));

        if ($uniqueRates === []) {
            return (int) $applicableRates->last()->rate;
        }

        return count($uniqueRates) === 1 ? $uniqueRates[0] : '変動';
    }

    private function uniqueSheetTitle(string $name, array &$usedTitles): string
    {
        $baseTitle = trim(preg_replace('/[\\\\\\/\\?\\*\\:\\[\\]]/u', '_', $name)) ?: 'sheet';
        $baseTitle = mb_substr($baseTitle, 0, 31);
        $title = $baseTitle;
        $suffix = 1;

        while (in_array(mb_strtolower($title), $usedTitles, true)) {
            $serial = '_' . $suffix;
            $title = mb_substr($baseTitle, 0, 31 - mb_strlen($serial)) . $serial;
            $suffix++;
        }

        $usedTitles[] = mb_strtolower($title);

        return $title;
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
