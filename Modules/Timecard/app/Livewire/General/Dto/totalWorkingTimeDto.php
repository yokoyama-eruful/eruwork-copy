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
        $overtimePremiumRate = $wagePremium?->overtime_rate / 100 ?? 0.0;
        $nightPremiumRate = $wagePremium?->night_rate / 100 ?? 0.0;

        $workTimes = WorkTime::with('breakTimes')
            ->where('user_id', $user->id)
            ->whereBetween('in_time', [$startDate, $endDate])
            ->get()
            ->filter(fn ($work) => $work->in_time && $work->out_time);

        $totalPay = 0;
        $dailyData = [];

        // 勤務データを日付別にグループ化
        foreach ($workTimes as $work) {
            $date = $work->in_time->toDateString();
            if (! isset($dailyData[$date])) {
                $dailyData[$date] = [];
            }
            $dailyData[$date][] = $work;
        }

        foreach ($dailyData as $date => $dayWorks) {
            $currentWorkDate = CarbonImmutable::parse($date);
            $applicableRate = $sortedHourlyRates->first(function ($rate) use ($currentWorkDate) {
                return CarbonImmutable::parse($rate->effective_date)->lte($currentWorkDate);
            });

            if (! $applicableRate) {
                continue;
            }

            $minuteWage = $applicableRate->rate / 60;

            // 勤務時間をすべて処理して、時間帯別に分類
            $timeSegments = self::buildTimeSegments(collect($dayWorks));

            $categorizedMinutes = [
                'regular' => 0,
                'night' => 0,
                'overtime' => 0,
                'night_overtime' => 0,
            ];

            $totalWorkMinutesToday = 0;

            foreach ($timeSegments as $segment) {
                $minutes = $segment['minutes'];
                $isNight = $segment['isNight'];
                $isOvertime = ($totalWorkMinutesToday + $minutes) > 8 * 60;
                $wasPreviouslyOvertime = $totalWorkMinutesToday >= 8 * 60;

                // 通常勤務から残業に切り替わる場合の処理
                if (! $wasPreviouslyOvertime && $isOvertime) {
                    $regularMinutes = max(0, 8 * 60 - $totalWorkMinutesToday);
                    $overtimeMinutes = $minutes - $regularMinutes;

                    if ($isNight) {
                        $categorizedMinutes['night'] += $regularMinutes;
                        $categorizedMinutes['night_overtime'] += $overtimeMinutes;
                    } else {
                        $categorizedMinutes['regular'] += $regularMinutes;
                        $categorizedMinutes['overtime'] += $overtimeMinutes;
                    }
                } else {
                    if ($isNight && $isOvertime) {
                        $categorizedMinutes['night_overtime'] += $minutes;
                    } elseif ($isOvertime) {
                        $categorizedMinutes['overtime'] += $minutes;
                    } elseif ($isNight) {
                        $categorizedMinutes['night'] += $minutes;
                    } else {
                        $categorizedMinutes['regular'] += $minutes;
                    }
                }

                $totalWorkMinutesToday += $minutes;
            }

            $dailyPay = 0;
            $dailyPay += $categorizedMinutes['regular'] * $minuteWage;
            $dailyPay += $categorizedMinutes['night'] * ($minuteWage * (1 + $nightPremiumRate));
            $dailyPay += $categorizedMinutes['overtime'] * ($minuteWage * (1 + $overtimePremiumRate));
            $dailyPay += $categorizedMinutes['night_overtime'] * ($minuteWage * (1 + $nightPremiumRate + $overtimePremiumRate));

            $totalPay += $dailyPay;
        }

        return (string) ceil($totalPay);
    }

    /**
     * 勤務時間をセグメント化し、夜間判定付きで返す
     * （分単位ループを排除）
     */
    private static function buildTimeSegments($dayWorks)
    {
        $segments = [];

        foreach ($dayWorks->sortBy('in_time') as $work) {
            $workStart = CarbonImmutable::parse($work->in_time);
            $workEnd = CarbonImmutable::parse($work->out_time);

            $breaks = $work->breakTimes
                ->map(fn ($bt) => [
                    'start' => CarbonImmutable::parse($bt->in_time),
                    'end' => CarbonImmutable::parse($bt->out_time),
                ])
                ->sortBy('start')
                ->values()
                ->all();

            $current = $workStart;

            foreach ($breaks as $break) {
                if ($current->lt($break['start'])) {
                    $minutes = $current->diffInMinutes($break['start']);
                    // 時間帯を判定：開始時刻と終了時刻どちらかが夜間なら夜間扱い
                    $isNight = ($current->hour >= 22 || $current->hour < 5) ||
                               ($break['start']->subMinute()->hour >= 22 || $break['start']->subMinute()->hour < 5);
                    $segments[] = [
                        'minutes' => $minutes,
                        'isNight' => $isNight,
                    ];
                }
                $current = $break['end'];
            }

            // 最後の勤務セグメント
            if ($current->lt($workEnd)) {
                $minutes = $current->diffInMinutes($workEnd);
                $isNight = ($current->hour >= 22 || $current->hour < 5) ||
                           ($workEnd->subMinute()->hour >= 22 || $workEnd->subMinute()->hour < 5);
                $segments[] = [
                    'minutes' => $minutes,
                    'isNight' => $isNight,
                ];
            }
        }

        return $segments;
    }
}
