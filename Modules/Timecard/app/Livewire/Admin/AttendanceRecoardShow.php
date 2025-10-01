<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Modules\HourlyRate\Models\WagePremium;
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
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->orderBy('date', 'asc')
            ->orderBy('in_time', 'asc')
            ->get();

        $breakTimes = BreakTime::query()
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->orderBy('in_time', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet;

        foreach ($selectedUsers as $user) {
            $clonedWorksheet = clone $spreadsheet->getSheetByName('Worksheet');
            $clonedWorksheet->setTitle($user->name);
            $userWorkTimes = $workTimes->where('user_id', $user->id)->map(function ($workTime) use ($breakTimes, $user) {
                $userWorkTimes = [];
                $totalBreakMinutes = 0;

                $dailyBreakTimes = $breakTimes->where('user_id', $user->id)->where('date', $workTime->date);

                foreach ($dailyBreakTimes as $breakTime) {
                    if ($breakTime->in_time >= $workTime->in_time && $breakTime->out_time <= $workTime->out_time) {
                        $totalBreakMinutes += $breakTime->in_time->diffInMinutes($breakTime->out_time);
                    }
                }

                $hours = floor($totalBreakMinutes / 60);
                $minutes = $totalBreakMinutes % 60;

                array_push($userWorkTimes, $workTime->date->isoFormat('YYYY/MM/DD(ddd)'), $workTime->in_time->format('H:i'), $workTime->out_time->format('H:i'), "{$hours}時間{$minutes}分");

                return $userWorkTimes;
            })->toArray();

            $spreadsheet->addSheet($clonedWorksheet);
            $worksheet = $spreadsheet->getSheetByName($user->name);
            $worksheet->fromArray([['日時', '出勤', '退勤', '合計休憩時間']], null, 'A1');
            $worksheet->fromArray($userWorkTimes, null, 'A2');
        }

        $spreadsheet->removeSheetByIndex(0);
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
        // // userを取得
        // $user = User::find($userId);

        // // 深夜割増を取得
        // $nightPremium = WagePremium::where('name', '深夜')->first();

        // // 早朝割増を取得
        // $morningPremium = WagePremium::where('name', '早朝')->first();

        // // 時給を取得
        // $hourlyRate = $user->hourlyRate()->where('effective_date', '<=', $this->endDate)->orderBy('effective_date', 'desc')->get();

        // $user = User::find($userId);

        // $wagePremium = WagePremium::where('name', '深夜')->first();
        // $premiumRate = $wagePremium ? 1 + ($wagePremium->rate / 100) : 1;

        // $startDate = CarbonImmutable::parse($this->startDate);
        // $endDate = CarbonImmutable::parse($this->endDate)->addDay()->subSecond();

        // $hourlyRateList = $user
        //     ->hourlyRate()
        //     ->whereBetween('effective_date', [$startDate, $endDate])
        //     ->get();

        // if ($hourlyRateList->isEmpty()) {
        //     return '--';
        // }

        // // 時給テーブル作成
        // $hourlyRateTable = [];
        // if ($startDate < $hourlyRateList->first()->effective_date) {
        //     $hourlyRateTable[] = (object) [
        //         'rate' => 0,
        //         'start_date' => $startDate,
        //         'end_date' => $hourlyRateList->has(0) ? $hourlyRateList[0]->effective_date->subSecond() : $endDate,
        //     ];
        // }
        // foreach ($hourlyRateList as $key => $hourlyRate) {
        //     $hourlyRateTable[] = (object) [
        //         'rate' => $hourlyRate->rate,
        //         'start_date' => $hourlyRate->effective_date,
        //         'end_date' => $hourlyRateList->has($key + 1) ? $hourlyRateList[$key + 1]->effective_date->subSecond() : $endDate,
        //     ];
        // }

        // $totalPay = 0;

        // foreach ($hourlyRateTable as $rateInfo) {
        //     $workTimes = WorkTime::with('breakTimes')
        //         ->where('user_id', $user->id)
        //         ->whereBetween('in_time', [$rateInfo->start_date, $rateInfo->end_date])
        //         ->whereNotNull('in_time')
        //         ->whereNotNull('out_time')
        //         ->get();

        //     foreach ($workTimes as $workTime) {
        //         $in = $workTime->in_time;
        //         $out = $workTime->out_time;

        //         $workMinutes = $in->diffInMinutes($out);
        //         $breakMinutes = $workTime->breakTimes->sum(fn ($b) => $b->in_time->diffInMinutes($b->out_time));
        //         $netMinutes = max($workMinutes - $breakMinutes, 0);

        //         $midnightMinutes = 0;

        //         // 深夜割増計算（設定があれば）
        //         if ($wagePremium) {
        //             $premiumStartForDay = $in->copy()->setTimeFrom($wagePremium->start_time);
        //             $premiumEndForDay = $in->copy()->setTimeFrom($wagePremium->end_time);

        //             if ($premiumEndForDay->lessThanOrEqualTo($premiumStartForDay)) {
        //                 $premiumEndForDay = $premiumEndForDay->addDay();
        //             }

        //             $overlapStart = $in->greaterThan($premiumStartForDay) ? $in : $premiumStartForDay;
        //             $overlapEnd = $out->lessThan($premiumEndForDay) ? $out : $premiumEndForDay;

        //             if ($overlapEnd->greaterThan($overlapStart)) {
        //                 $midnightMinutes = $overlapStart->diffInMinutes($overlapEnd);
        //             }
        //         }

        //         // 通常給与
        //         $totalPay += ($netMinutes - $midnightMinutes) / 60 * $rateInfo->rate;

        //         // 深夜割増給与
        //         if ($wagePremium) {
        //             $totalPay += ($midnightMinutes / 60) * $rateInfo->rate * $premiumRate;
        //         }
        //     }
        // }

        // return (string) floor($totalPay);

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
