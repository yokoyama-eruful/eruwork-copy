<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\General\Dto;

use App\Models\User;
use Carbon\CarbonImmutable;
use Modules\HourlyRate\Models\WagePremium;
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
        $workTimes = WorkTime::with('breakTimes')
            ->where('user_id', $user->id)
            ->whereBetween('in_time', [$startDate, $endDate])
            ->get();

        $totalPay = 0;

        $wagePremium = WagePremium::where('name', '深夜')->first();

        foreach ($workTimes as $work) {
            $in = $work->in_time;
            $out = $work->out_time;

            // out が null（退勤打刻なし）の場合はスキップ
            if (! $in || ! $out) {
                continue;
            }

            $workMinutes = $in->diffInMinutes($out);
            $breakMinutes = $work->breakTimes->sum(fn ($b) => ($b->in_time && $b->out_time) ? $b->in_time->diffInMinutes($b->out_time) : 0
            );
            $netMinutes = max($workMinutes - $breakMinutes, 0);

            $hourlyRate = $user->hourlyRate()
                ->where('effective_date', '<=', $in)
                ->orderByDesc('effective_date')
                ->first()?->rate ?? 0;

            $premiumMinutes = 0;

            if ($wagePremium) {
                $premiumStart = $in->copy()->setTimeFrom($wagePremium->start_time);
                $premiumEnd = $in->copy()->setTimeFrom($wagePremium->end_time);

                // 日跨ぎ対応
                if ($premiumEnd->lessThanOrEqualTo($premiumStart)) {
                    $premiumEnd = $premiumEnd->addDay();
                }

                $overlapStart = max($in->timestamp, $premiumStart->timestamp);
                $overlapEnd = min($out->timestamp, $premiumEnd->timestamp);

                if ($overlapEnd > $overlapStart) {
                    $premiumMinutes = ($overlapEnd - $overlapStart) / 60;
                }
            }

            $pay = ($netMinutes / 60) * $hourlyRate;

            if ($wagePremium) {
                $pay += ($premiumMinutes / 60) * $hourlyRate * ($wagePremium->rate / 100);
            }

            $totalPay += $pay;
        }

        return (string) floor($totalPay);
    }
}
