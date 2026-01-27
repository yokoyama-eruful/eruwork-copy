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

    // private static function calcPay(User $user, CarbonImmutable $startDate, CarbonImmutable $endDate): string
    // {
    //     $wagePremium = WagePremium::first();
    //     $baseHourlyWage = 1000;

    //     $overtimePremiumRate = $wagePremium?->overtime_rate / 100 ?? 0.25;
    //     $nightPremiumRate = $wagePremium?->night_rate / 100 ?? 0.25;

    //     $minuteWage = $baseHourlyWage / 60;

    //     $workTimes = WorkTime::with('breakTimes')
    //         ->where('user_id', $user->id)
    //         ->whereBetween('in_time', [$startDate, $endDate])
    //         ->get()
    //         ->filter(fn ($work) => $work->in_time && $work->out_time)
    //         ->groupBy(fn ($item) => CarbonImmutable::parse($item->in_time)->toDateString())
    //         ->sortKeys();

    //     $totalPay = 0;

    //     foreach ($workTimes as $date => $dayWorks) {
    //         $categorizedMinutes = [
    //             'regular' => 0,
    //             'night' => 0,
    //             'overtime' => 0,
    //             'night_overtime' => 0,
    //         ];
    //         $totalWorkMinutesToday = 0;

    //         $sortedWorks = $dayWorks->sortBy('in_time');

    //         foreach ($sortedWorks as $work) {
    //             $workStart = CarbonImmutable::parse($work->in_time);
    //             $workEnd = CarbonImmutable::parse($work->out_time);

    //             $durationMinutes = $workStart->diffInMinutes($workEnd);

    //             $breaks = $work->breakTimes->map(fn ($bt) => [
    //                 'start' => CarbonImmutable::parse($bt->in_time),
    //                 'end' => CarbonImmutable::parse($bt->out_time),
    //             ])->all();

    //             for ($i = 0; $i < $durationMinutes; $i++) {
    //                 $currentTime = $workStart->addMinutes($i);

    //                 $isBreaking = false;
    //                 foreach ($breaks as $break) {
    //                     $breakStart = $break['start']->second(0);
    //                     $breakEnd = $break['end']->second(0);
    //                     $currentTimeForCheck = $currentTime->second(0);
    //                     if ($currentTimeForCheck->gte($breakStart) && $currentTimeForCheck->lt($breakEnd)) {
    //                         $isBreaking = true;
    //                         break;
    //                     }
    //                 }
    //                 if ($isBreaking) {
    //                     continue;
    //                 }

    //                 $totalWorkMinutesToday++;

    //                 $isNight = $currentTime->hour >= 22 || $currentTime->hour < 5;
    //                 $isOvertime = $totalWorkMinutesToday > 8 * 60;

    //                 if ($isNight && $isOvertime) {
    //                     $categorizedMinutes['night_overtime']++;
    //                 } elseif ($isOvertime) {
    //                     $categorizedMinutes['overtime']++;
    //                 } elseif ($isNight) {
    //                     $categorizedMinutes['night']++;
    //                 } else {
    //                     $categorizedMinutes['regular']++;
    //                 }
    //             }
    //         }

    //         $dailyPay = 0;
    //         $dailyPay += $categorizedMinutes['regular'] * $minuteWage;
    //         $dailyPay += $categorizedMinutes['night'] * ($minuteWage * (1 + $nightPremiumRate));
    //         $dailyPay += $categorizedMinutes['overtime'] * ($minuteWage * (1 + $overtimePremiumRate));
    //         $dailyPay += $categorizedMinutes['night_overtime'] * ($minuteWage * (1 + $nightPremiumRate + $overtimePremiumRate));

    //         $totalPay += $dailyPay;
    //     }

    //     return (string) ceil($totalPay);
    // }

    private static function calcPay(User $user, CarbonImmutable $startDate, CarbonImmutable $endDate): string
    {
        // --- 基本設定 ---
        $wagePremium = WagePremium::first();

        // --- ユーザーの時給履歴を取得し、適用日の降順にソート ---
        $sortedHourlyRates = $user->hourlyRate->sortByDesc('effective_date');

        // --- 割増率 ---
        $overtimePremiumRate = $wagePremium?->overtime_rate / 100 ?? 0.0;
        $nightPremiumRate = $wagePremium?->night_rate / 100 ?? 0.0;

        // --- 勤務データを取得・整形 ---
        $workTimes = WorkTime::with('breakTimes')
            ->where('user_id', $user->id)
            ->whereBetween('in_time', [$startDate, $endDate])
            ->get()
            ->filter(fn ($work) => $work->in_time && $work->out_time)
            ->groupBy(fn ($item) => CarbonImmutable::parse($item->in_time)->toDateString())
            ->sortKeys();

        $totalPay = 0;

        // 1日ごとにループ
        foreach ($workTimes as $date => $dayWorks) {

            // ▼▼▼【修正点】日付比較を厳密に行う ▼▼▼
            $currentWorkDate = CarbonImmutable::parse($date); // 勤務日をCarbonオブジェクトに

            $applicableRate = $sortedHourlyRates->first(function ($rate) use ($currentWorkDate) {
                // 適用日もCarbonオブジェクトに変換して、lte() (less than or equal)で比較
                return CarbonImmutable::parse($rate->effective_date)->lte($currentWorkDate);
            });

            if (! $applicableRate) {
                continue;
            }

            $baseHourlyWage = $applicableRate->rate;
            $minuteWage = $baseHourlyWage / 60;

            $categorizedMinutes = [
                'regular' => 0, 'night' => 0, 'overtime' => 0, 'night_overtime' => 0,
            ];
            $totalWorkMinutesToday = 0;
            $sortedWorks = $dayWorks->sortBy('in_time');

            foreach ($sortedWorks as $work) {
                // タイムゾーンを指定
                $workStart = CarbonImmutable::parse($work->in_time);
                $workEnd = CarbonImmutable::parse($work->out_time);
                $durationMinutes = $workStart->diffInMinutes($workEnd);
                $breaks = $work->breakTimes->map(fn ($bt) => [
                    'start' => CarbonImmutable::parse($bt->in_time),
                    'end' => CarbonImmutable::parse($bt->out_time),
                ])->all();

                for ($i = 0; $i < $durationMinutes; $i++) {
                    $currentTime = $workStart->addMinutes($i);
                    $isBreaking = false;
                    foreach ($breaks as $break) {
                        $breakStart = $break['start']->second(0);
                        $breakEnd = $break['end']->second(0);
                        $currentTimeForCheck = $currentTime->second(0);
                        if ($currentTimeForCheck->gte($breakStart) && $currentTimeForCheck->lt($breakEnd)) {
                            $isBreaking = true;
                            break;
                        }
                    }
                    if ($isBreaking) {
                        continue;
                    }

                    $totalWorkMinutesToday++;
                    $isNight = $currentTime->hour >= 22 || $currentTime->hour < 5;
                    $isOvertime = $totalWorkMinutesToday > 8 * 60;

                    if ($isNight && $isOvertime) {
                        $categorizedMinutes['night_overtime']++;
                    } elseif ($isOvertime) {
                        $categorizedMinutes['overtime']++;
                    } elseif ($isNight) {
                        $categorizedMinutes['night']++;
                    } else {
                        $categorizedMinutes['regular']++;
                    }
                }
            }

            // --- カテゴリごとの単価で給与を計算 ---
            $dailyPay = 0;
            $dailyPay += $categorizedMinutes['regular'] * $minuteWage;
            $dailyPay += $categorizedMinutes['night'] * ($minuteWage * (1 + $nightPremiumRate));
            $dailyPay += $categorizedMinutes['overtime'] * ($minuteWage * (1 + $overtimePremiumRate));
            $dailyPay += $categorizedMinutes['night_overtime'] * ($minuteWage * (1 + $nightPremiumRate + $overtimePremiumRate));

            $totalPay += $dailyPay;
        }

        // --- 最終的な端数処理 ---
        return (string) ceil($totalPay);
    }
}
