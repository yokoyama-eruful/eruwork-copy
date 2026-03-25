<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\General\Dto;

use App\Models\User;
use Carbon\CarbonImmutable;
use Modules\Timecard\Services\WageCalculationService;

class totalWorkingTimeDto
{
    public static function month(User $user, CarbonImmutable $date): string
    {
        return self::calcTotalMinutesFormatted(
            $user,
            $date->startOfMonth(),
            $date->endOfMonth()
        );
    }

    public static function year(User $user, CarbonImmutable $date): string
    {
        return self::calcTotalMinutesFormatted(
            $user,
            $date->startOfYear(),
            $date->endOfYear()
        );
    }

    private static function calcTotalMinutesFormatted(User $user, CarbonImmutable $start, CarbonImmutable $end): string
    {
        /** @var WageCalculationService $service */
        $service = app(WageCalculationService::class);
        $summary = $service->summarize($user, $start, $end);
        $totalMinutes = array_sum($summary['minutes']);

        return sprintf('%01d:%02d', intdiv($totalMinutes, 60), $totalMinutes % 60);
    }

    public static function monthPay(User $user, CarbonImmutable $date): string
    {
        return self::calcPay($user, $date->startOfMonth(), $date->endOfMonth());
    }

    public static function yearPay(User $user, CarbonImmutable $date): string
    {
        return self::calcPay($user, $date->startOfYear(), $date->endOfYear());
    }

    public static function selectDatePay(User $user, CarbonImmutable $startDate, CarbonImmutable $endDate): string
    {
        return self::calcPay($user, $startDate, $endDate);
    }

    private static function calcPay(User $user, CarbonImmutable $startDate, CarbonImmutable $endDate): string
    {
        /** @var WageCalculationService $service */
        $service = app(WageCalculationService::class);
        $summary = $service->summarize($user, $startDate, $endDate);

        return $summary['totalPay'];
    }
}
