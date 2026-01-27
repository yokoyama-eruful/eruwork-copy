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
    //     // --- 基本設定 ---
    //     $wagePremium = WagePremium::first();

    //     // --- ユーザーの時給履歴を取得し、適用日の降順にソート ---
    //     $sortedHourlyRates = $user->hourlyRate->sortByDesc('effective_date');

    //     // --- 割増率 ---
    //     $overtimePremiumRate = $wagePremium?->overtime_rate / 100 ?? 0.0;
    //     $nightPremiumRate = $wagePremium?->night_rate / 100 ?? 0.0;

    //     // --- 勤務データを取得・整形 ---
    //     $workTimes = WorkTime::with('breakTimes')
    //         ->where('user_id', $user->id)
    //         ->whereBetween('in_time', [$startDate, $endDate])
    //         ->get()
    //         ->filter(fn ($work) => $work->in_time && $work->out_time)
    //         ->groupBy(fn ($item) => CarbonImmutable::parse($item->in_time)->toDateString())
    //         ->sortKeys();

    //     $totalPay = 0;

    //     // 1日ごとにループ
    //     foreach ($workTimes as $date => $dayWorks) {

    //         // ▼▼▼【修正点】日付比較を厳密に行う ▼▼▼
    //         $currentWorkDate = CarbonImmutable::parse($date); // 勤務日をCarbonオブジェクトに

    //         $applicableRate = $sortedHourlyRates->first(function ($rate) use ($currentWorkDate) {
    //             // 適用日もCarbonオブジェクトに変換して、lte() (less than or equal)で比較
    //             return CarbonImmutable::parse($rate->effective_date)->lte($currentWorkDate);
    //         });

    //         if (! $applicableRate) {
    //             continue;
    //         }

    //         $baseHourlyWage = $applicableRate->rate;
    //         $minuteWage = $baseHourlyWage / 60;

    //         $categorizedMinutes = [
    //             'regular' => 0, 'night' => 0, 'overtime' => 0, 'night_overtime' => 0,
    //         ];
    //         $totalWorkMinutesToday = 0;
    //         $sortedWorks = $dayWorks->sortBy('in_time');

    //         foreach ($sortedWorks as $work) {
    //             // タイムゾーンを指定
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

    //         // --- カテゴリごとの単価で給与を計算 ---
    //         $dailyPay = 0;
    //         $dailyPay += $categorizedMinutes['regular'] * $minuteWage;
    //         $dailyPay += $categorizedMinutes['night'] * ($minuteWage * (1 + $nightPremiumRate));
    //         $dailyPay += $categorizedMinutes['overtime'] * ($minuteWage * (1 + $overtimePremiumRate));
    //         $dailyPay += $categorizedMinutes['night_overtime'] * ($minuteWage * (1 + $nightPremiumRate + $overtimePremiumRate));

    //         $totalPay += $dailyPay;
    //     }

    //     // --- 最終的な端数処理 ---
    //     return (string) ceil($totalPay);
    // }

    private static function calcPay(User $user, CarbonImmutable $startDate, CarbonImmutable $endDate): string
    {
        $wagePremium = WagePremium::first();
        $sortedHourlyRates = $user->hourlyRate->sortByDesc('effective_date');
        $overtimePremiumRate = $wagePremium?->overtime_rate / 100 ?? 0.0;
        $nightPremiumRate = $wagePremium?->night_rate / 100 ?? 0.0;

        // 勤務データ取得（Eager Loadingは継続）
        $workTimes = WorkTime::with('breakTimes')
            ->where('user_id', $user->id)
            ->whereBetween('in_time', [$startDate, $endDate])
            ->get()
            ->filter(fn ($work) => $work->in_time && $work->out_time)
            ->groupBy(fn ($item) => $item->in_time->toDateString());

        $totalPay = 0;

        foreach ($workTimes as $date => $dayWorks) {
            $currentWorkDate = CarbonImmutable::parse($date);
            $applicableRate = $sortedHourlyRates->first(fn ($rate) => CarbonImmutable::parse($rate->effective_date)->lte($currentWorkDate));
            if (! $applicableRate) {
                continue;
            }

            $minuteWage = $applicableRate->rate / 60;
            $dailyTotalWorkMinutes = 0;
            $dailyPay = 0;

            foreach ($dayWorks->sortBy('in_time') as $work) {
                $in = $work->in_time;
                $out = $work->out_time;

                // 1. 総労働時間（休憩含む）
                $totalMinutes = $in->diffInMinutes($out);

                // 2. 休憩時間の合計
                $breakMinutes = $work->breakTimes->sum(fn ($b) => $b->in_time->diffInMinutes($b->out_time));

                // 3. 実労働時間
                $actualWorkMinutes = max(0, $totalMinutes - $breakMinutes);

                // --- 深夜労働の判定（ループなし） ---
                // 22:00 - 05:00 の範囲に被っている時間を算出するロジック
                $nightMinutes = self::calculateNightMinutes($in, $out, $work->breakTimes);

                // --- 残業代の判定 ---
                // その日の累積時間が480分(8時間)を超えた分を算出
                $beforeAccumulated = $dailyTotalWorkMinutes;
                $dailyTotalWorkMinutes += $actualWorkMinutes;

                $overtimeMinutes = 0;
                if ($dailyTotalWorkMinutes > 480) {
                    $overtimeMinutes = ($beforeAccumulated > 480)
                        ? $actualWorkMinutes
                        : $dailyTotalWorkMinutes - 480;
                }

                $regularMinutes = $actualWorkMinutes - $overtimeMinutes;

                // 基本給 + 残業割増 + 深夜割増
                $dailyPay += ($actualWorkMinutes * $minuteWage);
                $dailyPay += ($overtimeMinutes * $minuteWage * $overtimePremiumRate);
                $dailyPay += ($nightMinutes * $minuteWage * $nightPremiumRate);
            }
            $totalPay += $dailyPay;
        }

        return (string) ceil($totalPay);
    }

    private static function calculateNightMinutes($in, $out, $breakTimes): int
    {
        $nightMinutes = 0;
        $duration = $in->diffInMinutes($out);

        for ($i = 0; $i < $duration; $i++) {
            $t = $in->addMinutes($i);
            $hour = $t->hour;

            // 深夜時間帯の判定
            if ($hour >= 22 || $hour < 5) {
                $isBreak = false;
                foreach ($breakTimes as $b) {
                    // breakTimesのin_time/out_timeが未設定、またはnullの場合のケア
                    if (! $b->in_time || ! $b->out_time) {
                        continue;
                    }

                    // $t の秒を0にして比較の精度を上げる
                    $currentTime = $t->startOfMinute();
                    if ($currentTime->gte($b->in_time->startOfMinute()) && $currentTime->lt($b->out_time->startOfMinute())) {
                        $isBreak = true;
                        break;
                    }
                }
                if (! $isBreak) {
                    $nightMinutes++;
                }
            }
        }

        return $nightMinutes;
    }
}
