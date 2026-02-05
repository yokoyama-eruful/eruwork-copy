<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\General\Dto;

use App\Models\User;
use Carbon\CarbonImmutable;
use Modules\Timecard\Models\WagePremium;
use Modules\Timecard\Models\WorkTime;

class totalWorkingTimeDto
{
    public static function month(User $user, CarbonImmutable $date): string
    {
        $start = $date->startOfMonth();
        $end = $date->endOfMonth();

        $workTimes = WorkTime::with('breakTimes')
            ->where('user_id', $user->id)
            ->whereBetween('in_time', [$start, $end])
            ->get();

        return self::calcTotalMinutesFormatted($workTimes);
    }

    public static function year(User $user, CarbonImmutable $date): string
    {
        $start = $date->startOfYear();
        $end = $date->endOfYear();

        $workTimes = WorkTime::with('breakTimes')
            ->where('user_id', $user->id)
            ->whereBetween('in_time', [$start, $end])
            ->get();

        return self::calcTotalMinutesFormatted($workTimes);
    }

    private static function calcTotalMinutesFormatted($workTimes): string
    {
        $totalMinutes = 0;

        foreach ($workTimes as $work) {
            $workMinutes = $work->in_time->diffInMinutes($work->out_time);

            $breakMinutes = $work->breakTimes->sum(function ($b) {
                return $b->in_time->diffInMinutes($b->out_time);
            });

            $totalMinutes += max($workMinutes - $breakMinutes, 0);
        }

        return sprintf('%01d:%02d', floor($totalMinutes / 60), $totalMinutes % 60);
    }

    public static function monthPay(User $user, CarbonImmutable $date): string
    {
        $start = $date->startOfMonth();
        $end = $date->endOfMonth();

        return self::calcPay($user, $start, $end);
    }

    public static function yearPay(User $user, CarbonImmutable $date): string
    {
        $start = $date->startOfYear();
        $end = $date->endOfYear();

        return self::calcPay($user, $start, $end);
    }

    public static function selectDatePay(User $user, CarbonImmutable $startDate, CarbonImmutable $endDate): string
    {
        return self::calcPay($user, $startDate, $endDate);
    }

    private static function calcPay(User $user, CarbonImmutable $startDate, CarbonImmutable $endDate): string
    {
        $wagePremium = WagePremium::first();
        $sortedHourlyRates = $user->hourlyRate->sortByDesc('effective_date');

        // 割増率をBCMath用に準備
        $overtimePremiumRate = (string) ($wagePremium?->overtime_rate / 100 ?? 0.0);
        $nightPremiumRate = (string) ($wagePremium?->night_rate / 100 ?? 0.0);

        $workTimes = WorkTime::with('breakTimes')
            ->where('user_id', $user->id)
            ->whereBetween('in_time', [$startDate, $endDate])
            ->get()
            ->filter(fn ($work) => $work->in_time && $work->out_time);

        $totalPay = '0';

        foreach ($workTimes->groupBy(fn ($w) => $w->in_time->toDateString()) as $date => $dayWorks) {
            $currentWorkDate = CarbonImmutable::parse($date);
            $applicableRate = $sortedHourlyRates->first(fn ($r) => CarbonImmutable::parse($r->effective_date)->lte($currentWorkDate));

            if (! $applicableRate) {
                continue;
            }

            $hourlyRate = (string) $applicableRate->rate;
            $timeSegments = self::buildTimeSegments($dayWorks);

            $totalWorkMinutesToday = 0;
            $dailyPay = '0';

            foreach ($timeSegments as $segment) {
                $minutes = $segment['minutes'];
                $isNight = $segment['isNight'];

                // 残業判定のロジック
                $regularLimit = 8 * 60;
                $currentSegmentRegularMinutes = 0;
                $currentSegmentOvertimeMinutes = 0;

                if ($totalWorkMinutesToday >= $regularLimit) {
                    $currentSegmentOvertimeMinutes = $minutes;
                } elseif ($totalWorkMinutesToday + $minutes > $regularLimit) {
                    $currentSegmentRegularMinutes = $regularLimit - $totalWorkMinutesToday;
                    $currentSegmentOvertimeMinutes = $minutes - $currentSegmentRegularMinutes;
                } else {
                    $currentSegmentRegularMinutes = $minutes;
                }

                // --- 金額計算 (BCMath) ---
                // 1分あたりの単価 = 時給 / 60
                $minuteWage = bcdiv($hourlyRate, '60', 10);

                // 通常/深夜の倍率計算
                $rateMultiplier = '1.0';
                if ($isNight) {
                    $rateMultiplier = bcadd($rateMultiplier, $nightPremiumRate, 4);
                }

                // 1. 通常/深夜分
                if ($currentSegmentRegularMinutes > 0) {
                    $amount = bcmul($minuteWage, (string) $currentSegmentRegularMinutes, 10);
                    $amount = bcmul($amount, $rateMultiplier, 10);
                    $dailyPay = bcadd($dailyPay, $amount, 10);
                }

                // 2. 残業（通常残業/深夜残業）分
                if ($currentSegmentOvertimeMinutes > 0) {
                    $otMultiplier = bcadd($rateMultiplier, $overtimePremiumRate, 4);
                    $amount = bcmul($minuteWage, (string) $currentSegmentOvertimeMinutes, 10);
                    $amount = bcmul($amount, $otMultiplier, 10);
                    $dailyPay = bcadd($dailyPay, $amount, 10);
                }

                $totalWorkMinutesToday += $minutes;
            }
            $totalPay = bcadd($totalPay, $dailyPay, 10);
        }

        // 最後に切り上げ
        return self::bcceil($totalPay);
    }

    /**
     * 22:00と05:00の境界でセグメントを強制分割する
     */
    private static function buildTimeSegments($dayWorks)
    {
        $segments = [];
        foreach ($dayWorks->sortBy('in_time') as $work) {
            $start = CarbonImmutable::parse($work->in_time);
            $end = CarbonImmutable::parse($work->out_time);
            $breaks = $work->breakTimes->map(fn ($b) => ['s' => CarbonImmutable::parse($b->in_time), 'e' => CarbonImmutable::parse($b->out_time)]);

            $current = $start;
            while ($current->lt($end)) {
                // 休憩時間中かチェック
                $inBreak = $breaks->first(fn ($b) => $current->gte($b['s']) && $current->lt($b['e']));
                if ($inBreak) {
                    $current = $inBreak['e'];

                    continue;
                }

                // 次の「イベント」までの時間を切り出す
                // イベント：休憩開始、勤務終了、または深夜/日中の境界(05:00, 22:00)
                $nextEvent = $end;

                // 休憩開始が先ならそこまで
                foreach ($breaks as $b) {
                    if ($b['s']->gt($current) && $b['s']->lt($nextEvent)) {
                        $nextEvent = $b['s'];
                    }
                }

                // 境界線(05:00, 22:00)が先ならそこまで
                $boundaries = [$current->setTime(5, 0), $current->setTime(22, 0), $current->addDay()->setTime(5, 0)];
                foreach ($boundaries as $bd) {
                    if ($bd->gt($current) && $bd->lt($nextEvent)) {
                        $nextEvent = $bd;
                    }
                }

                $minutes = $current->diffInMinutes($nextEvent);
                if ($minutes > 0) {
                    $segments[] = [
                        'minutes' => $minutes,
                        'isNight' => ($current->hour >= 22 || $current->hour < 5),
                    ];
                }
                $current = $nextEvent;
            }
        }

        return $segments;
    }

    // bcceil ヘルパー（BCMathには直接のceilがないため）
    private static function bcceil(string $number): string
    {
        if (mb_strpos($number, '.') !== false) {
            // 小数点以下がすべて0（例: "100.000"）なら、そのまま整数部を返す
            if (preg_match('/\.0+$/', $number)) {
                return bcadd($number, '0', 0);
            }
            // 正の数の場合、1を足して小数点以下を切り捨てる
            if (bccomp($number, '0', 10) >= 0) {
                return bcadd($number, '1', 0);
            }

            // 負の数の場合、単に小数点以下を切り捨てる（-1.5 -> -1）
            return bcadd($number, '0', 0);
        }

        return $number;
    }
}
