<?php

declare(strict_types=1);

namespace Modules\Timecard\Services;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\WagePremium;
use Modules\Timecard\Models\WorkTime;
use Modules\Timecard\Support\WorkdayBoundary;

class WageCalculationService
{
    public const WEEK_START_DAY = CarbonImmutable::SUNDAY;

    private const DAILY_LIMIT_MINUTES = 8 * 60;

    private const WEEKLY_LIMIT_MINUTES = 40 * 60;

    private const MONTHLY_OVERTIME_LIMIT_MINUTES = 60 * 60;

    private const DEFAULT_HOLIDAY_RATE = '0.35';

    private const DEFAULT_OVERTIME_OVER_60_RATE = '0.50';

    public function summarize(User $user, CarbonImmutable $startDate, CarbonImmutable $endDate): array
    {
        $visibleStart = WorkdayBoundary::startOfDate($startDate);
        $visibleEnd = WorkdayBoundary::endOfDate($endDate);
        $contextStart = WorkdayBoundary::startOfDate(
            $startDate->startOfMonth()->startOfWeek(self::WEEK_START_DAY)
        );

        $wagePremium = WagePremium::first();
        $hourlyRates = $user->hourlyRate->sortByDesc('effective_date');
        $segments = $this->buildSegments($user->id, $contextStart, $visibleEnd);

        $minutesByDay = [];
        $minutesByWeek = [];
        $monthlyOvertimeMinutes = [];
        $totals = $this->emptyBuckets();
        $payBuckets = $this->emptyPayBuckets();
        $thresholds = $this->emptyThresholds();
        $rowThresholds = [];
        $rows = [];
        $totalPay = '0';
        $overtimeRate = $this->normalizeRate($wagePremium?->overtime_rate);
        $nightRate = $this->normalizeRate($wagePremium?->night_rate);
        $holidayRate = $this->resolveConfiguredRate(
            $wagePremium?->holiday_rate,
            self::DEFAULT_HOLIDAY_RATE
        );
        $useStatutoryHolidayBucket = $this->usesStatutoryHolidayBucket($user);
        $overtimeOver60Rate = $this->resolveConfiguredRate(
            $wagePremium?->overtime_over_60_rate,
            self::DEFAULT_OVERTIME_OVER_60_RATE
        );

        foreach ($segments as $segment) {
            $startedAt = $segment['start'];
            $businessDate = WorkdayBoundary::businessDate($startedAt);
            $dateKey = $businessDate->toDateString();
            $weekKey = $businessDate->startOfWeek(self::WEEK_START_DAY)->toDateString();
            $monthKey = $businessDate->format('Y-m');
            $isVisible = $startedAt->gte($visibleStart) && $startedAt->lt($visibleEnd);

            if ($useStatutoryHolidayBucket && $segment['isHoliday']) {
                $bucket = $segment['isNight'] ? 'holidayNight' : 'holiday';
                $this->addMinutes($totals, $rows, $segment['workTimeId'], $bucket, $segment['minutes'], $isVisible);
                $amount = $this->calculatePayAmount(
                    $hourlyRates,
                    $startedAt,
                    $segment['minutes'],
                    $bucket,
                    $nightRate,
                    $overtimeRate,
                    $overtimeOver60Rate,
                    $holidayRate,
                    $isVisible
                );
                $this->addPay($payBuckets, $bucket, $amount, $isVisible);
                $totalPay = bcadd($totalPay, $amount, 10);

                continue;
            }

            $dailyRemaining = max(self::DAILY_LIMIT_MINUTES - ($minutesByDay[$dateKey] ?? 0), 0);
            $weeklyRemaining = max(self::WEEKLY_LIMIT_MINUTES - ($minutesByWeek[$weekKey] ?? 0), 0);
            $regularCapacity = min($dailyRemaining, $weeklyRemaining);
            $regularMinutes = (int) min($segment['minutes'], $regularCapacity);
            $overtimeMinutes = (int) ($segment['minutes'] - $regularMinutes);
            $weeklyExceededMinutes = (int) min(
                $overtimeMinutes,
                max($segment['minutes'] - $weeklyRemaining, 0)
            );

            if ($weeklyExceededMinutes > 0) {
                $this->addThresholdMinutes(
                    $thresholds,
                    $rowThresholds,
                    $segment['workTimeId'],
                    'weeklyOver40',
                    $weeklyExceededMinutes,
                    $isVisible
                );
            }

            if ($regularMinutes > 0) {
                $bucket = $segment['isNight'] ? 'night' : 'regular';
                $this->addMinutes($totals, $rows, $segment['workTimeId'], $bucket, $regularMinutes, $isVisible);
                $amount = $this->calculatePayAmount(
                    $hourlyRates,
                    $startedAt,
                    $regularMinutes,
                    $bucket,
                    $nightRate,
                    $overtimeRate,
                    $overtimeOver60Rate,
                    $holidayRate,
                    $isVisible
                );
                $this->addPay($payBuckets, $bucket, $amount, $isVisible);
                $totalPay = bcadd($totalPay, $amount, 10);
            }

            if ($overtimeMinutes > 0) {
                $under60Capacity = max(
                    self::MONTHLY_OVERTIME_LIMIT_MINUTES - ($monthlyOvertimeMinutes[$monthKey] ?? 0),
                    0
                );
                $overtimeUnder60Minutes = (int) min($overtimeMinutes, $under60Capacity);
                $overtimeOver60Minutes = (int) ($overtimeMinutes - $overtimeUnder60Minutes);

                if ($overtimeUnder60Minutes > 0) {
                    $bucket = $segment['isNight'] ? 'overtimeNight' : 'overtime';
                    $this->addMinutes($totals, $rows, $segment['workTimeId'], $bucket, $overtimeUnder60Minutes, $isVisible);
                    $amount = $this->calculatePayAmount(
                        $hourlyRates,
                        $startedAt,
                        $overtimeUnder60Minutes,
                        $bucket,
                        $nightRate,
                        $overtimeRate,
                        $overtimeOver60Rate,
                        $holidayRate,
                        $isVisible
                    );
                    $this->addPay($payBuckets, $bucket, $amount, $isVisible);
                    $totalPay = bcadd($totalPay, $amount, 10);
                }

                if ($overtimeOver60Minutes > 0) {
                    $bucket = $segment['isNight'] ? 'overtimeOver60Night' : 'overtimeOver60';
                    $this->addMinutes($totals, $rows, $segment['workTimeId'], $bucket, $overtimeOver60Minutes, $isVisible);
                    $amount = $this->calculatePayAmount(
                        $hourlyRates,
                        $startedAt,
                        $overtimeOver60Minutes,
                        $bucket,
                        $nightRate,
                        $overtimeRate,
                        $overtimeOver60Rate,
                        $holidayRate,
                        $isVisible
                    );
                    $this->addPay($payBuckets, $bucket, $amount, $isVisible);
                    $totalPay = bcadd($totalPay, $amount, 10);
                    $this->addThresholdMinutes(
                        $thresholds,
                        $rowThresholds,
                        $segment['workTimeId'],
                        'monthlyOver60',
                        $overtimeOver60Minutes,
                        $isVisible
                    );
                }

                $monthlyOvertimeMinutes[$monthKey] = ($monthlyOvertimeMinutes[$monthKey] ?? 0) + $overtimeMinutes;
            }

            $minutesByDay[$dateKey] = ($minutesByDay[$dateKey] ?? 0) + $segment['minutes'];
            $minutesByWeek[$weekKey] = ($minutesByWeek[$weekKey] ?? 0) + $segment['minutes'];
        }

        return [
            'minutes' => $totals,
            'payBuckets' => $payBuckets,
            'thresholds' => $thresholds,
            'rowThresholds' => $rowThresholds,
            'rows' => $rows,
            'totalPay' => $this->bcceil($totalPay),
        ];
    }

    private function buildSegments(int $userId, CarbonImmutable $start, CarbonImmutable $end): array
    {
        $workTimes = WorkTime::query()
            ->where('user_id', $userId)
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->where('in_time', '<', $end)
            ->where('out_time', '>', $start)
            ->with('breakTimes')
            ->orderBy('in_time')
            ->get();

        $segments = [];

        foreach ($workTimes as $workTime) {
            $workStart = CarbonImmutable::parse($workTime->in_time);
            $workEnd = CarbonImmutable::parse($workTime->out_time);

            if ($workEnd->lte($start) || $workStart->gte($end)) {
                continue;
            }

            $breaks = $workTime->breakTimes
                ->filter(fn ($break) => $break->in_time && $break->out_time)
                ->map(function (BreakTime $break) use ($start, $end): array {
                    $breakStart = CarbonImmutable::parse($break->in_time);
                    $breakEnd = CarbonImmutable::parse($break->out_time);

                    return [
                        'start' => $breakStart->lt($start) ? $start : $breakStart,
                        'end' => $breakEnd->gt($end) ? $end : $breakEnd,
                    ];
                })
                ->filter(fn (array $break): bool => $break['start']->lt($break['end']))
                ->sortBy('start')
                ->values();

            $current = $workStart->lt($start) ? $start : $workStart;
            $workEnd = $workEnd->gt($end) ? $end : $workEnd;

            while ($current->lt($workEnd)) {
                $activeBreak = $breaks->first(function (array $break) use ($current): bool {
                    return $current->gte($break['start']) && $current->lt($break['end']);
                });

                if ($activeBreak) {
                    $current = $activeBreak['end'];

                    continue;
                }

                $nextEvent = $workEnd;

                foreach ($breaks as $break) {
                    if ($break['start']->gt($current) && $break['start']->lt($nextEvent)) {
                        $nextEvent = $break['start'];
                    }
                }

                foreach ($this->segmentBoundaries($current) as $boundary) {
                    if ($boundary->gt($current) && $boundary->lt($nextEvent)) {
                        $nextEvent = $boundary;
                    }
                }

                $minutes = (int) $current->diffInMinutes($nextEvent);
                if ($minutes > 0) {
                    $segments[] = [
                        'workTimeId' => $workTime->id,
                        'start' => $current,
                        'minutes' => $minutes,
                        'isNight' => $this->isNight($current),
                        'isHoliday' => $this->isStatutoryHoliday($current),
                    ];
                }

                $current = $nextEvent;
            }
        }

        return $segments;
    }

    private function segmentBoundaries(CarbonImmutable $dateTime): array
    {
        $nextWorkdayBoundary = WorkdayBoundary::endOfDate(
            WorkdayBoundary::businessDate($dateTime)
        );

        return [
            $nextWorkdayBoundary,
            $dateTime->setTime(5, 0),
            $dateTime->setTime(22, 0),
            $dateTime->addDay()->setTime(5, 0),
            $dateTime->addDay()->setTime(22, 0),
        ];
    }

    private function isNight(CarbonImmutable $dateTime): bool
    {
        return $dateTime->hour >= 22 || $dateTime->hour < 5;
    }

    private function isStatutoryHoliday(CarbonImmutable $dateTime): bool
    {
        return WorkdayBoundary::isHoliday($dateTime);
    }

    private function usesStatutoryHolidayBucket(User $user): bool
    {
        return $user->profile?->contract_type !== 'アルバイト';
    }

    private function emptyBuckets(): array
    {
        return [
            'regular' => 0,
            'overtime' => 0,
            'overtimeOver60' => 0,
            'night' => 0,
            'overtimeNight' => 0,
            'overtimeOver60Night' => 0,
            'holiday' => 0,
            'holidayNight' => 0,
        ];
    }

    private function emptyPayBuckets(): array
    {
        return [
            'regular' => '0',
            'overtime' => '0',
            'overtimeOver60' => '0',
            'night' => '0',
            'overtimeNight' => '0',
            'overtimeOver60Night' => '0',
            'holiday' => '0',
            'holidayNight' => '0',
        ];
    }

    private function emptyThresholds(): array
    {
        return [
            'weeklyOver40' => 0,
            'monthlyOver60' => 0,
        ];
    }

    private function addMinutes(array &$totals, array &$rows, int $workTimeId, string $bucket, int $minutes, bool $isVisible): void
    {
        if (! $isVisible) {
            return;
        }

        $totals[$bucket] += $minutes;
        $rows[$workTimeId] ??= $this->emptyBuckets();
        $rows[$workTimeId][$bucket] += $minutes;
    }

    private function addThresholdMinutes(
        array &$thresholds,
        array &$rowThresholds,
        int $workTimeId,
        string $key,
        int $minutes,
        bool $isVisible
    ): void {
        if (! $isVisible || $minutes <= 0) {
            return;
        }

        $thresholds[$key] += $minutes;
        $rowThresholds[$workTimeId] ??= $this->emptyThresholds();
        $rowThresholds[$workTimeId][$key] += $minutes;
    }

    private function calculatePayAmount(
        Collection $hourlyRates,
        CarbonImmutable $date,
        int $minutes,
        string $bucket,
        string $nightRate,
        string $overtimeRate,
        string $overtimeOver60Rate,
        string $holidayRate,
        bool $isVisible
    ): string {
        if (! $isVisible || $minutes <= 0) {
            return '0';
        }

        $applicableRate = $hourlyRates->first(
            fn ($rate) => CarbonImmutable::parse($rate->effective_date)->startOfDay()->lte($date->startOfDay())
        );

        if (! $applicableRate) {
            return '0';
        }

        $multiplier = match ($bucket) {
            'regular' => '1.0',
            'night' => bcadd('1.0', $nightRate, 4),
            'overtime' => bcadd('1.0', $overtimeRate, 4),
            'overtimeNight' => bcadd(bcadd('1.0', $overtimeRate, 4), $nightRate, 4),
            'overtimeOver60' => bcadd('1.0', $overtimeOver60Rate, 4),
            'overtimeOver60Night' => bcadd(bcadd('1.0', $overtimeOver60Rate, 4), $nightRate, 4),
            'holiday' => bcadd('1.0', $holidayRate, 4),
            'holidayNight' => bcadd(bcadd('1.0', $holidayRate, 4), $nightRate, 4),
        };

        $minuteWage = bcdiv((string) $applicableRate->rate, '60', 10);
        $amount = bcmul($minuteWage, (string) $minutes, 10);

        return bcmul($amount, $multiplier, 10);
    }

    private function addPay(array &$payBuckets, string $bucket, string $amount, bool $isVisible): void
    {
        if (! $isVisible || $amount === '0') {
            return;
        }

        $payBuckets[$bucket] = bcadd($payBuckets[$bucket], $amount, 10);
    }

    private function normalizeRate(null|int|string|float $rate): string
    {
        return bcdiv((string) ($rate ?? 0), '100', 4);
    }

    private function resolveConfiguredRate(null|int|string|float $rate, string $defaultRate): string
    {
        if ($rate === null || $rate === '') {
            return $defaultRate;
        }

        return $this->normalizeRate($rate);
    }

    private function bcceil(string $number): string
    {
        if (mb_strpos($number, '.') === false) {
            return $number;
        }

        if (preg_match('/\.0+$/', $number) === 1) {
            return bcadd($number, '0', 0);
        }

        return bcadd($number, '1', 0);
    }
}
