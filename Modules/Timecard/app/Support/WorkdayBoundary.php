<?php

declare(strict_types=1);

namespace Modules\Timecard\Support;

use Carbon\CarbonImmutable;
use Modules\Timecard\Models\Rule;

class WorkdayBoundary
{
    private const DEFAULT_START_TIME = '00:00:00';

    private static ?string $cachedStartTime = null;

    private static ?int $cachedStatutoryHolidayWeekday = null;

    private static ?array $cachedHolidayWeekdays = null;

    private static ?array $cachedHolidayDates = null;

    private static ?array $cachedAnnualHolidayDates = null;

    public static function startTime(): string
    {
        if (self::$cachedStartTime !== null) {
            return self::$cachedStartTime;
        }

        return self::$cachedStartTime = Rule::query()->value('workday_start_time') ?? self::DEFAULT_START_TIME;
    }

    public static function setCachedStartTime(?string $startTime): void
    {
        self::$cachedStartTime = $startTime;
    }

    public static function statutoryHolidayWeekday(): int
    {
        if (self::$cachedStatutoryHolidayWeekday !== null) {
            return self::$cachedStatutoryHolidayWeekday;
        }

        return self::$cachedStatutoryHolidayWeekday = (int) (Rule::query()->value('statutory_holiday_weekday') ?? 0);
    }

    public static function setCachedStatutoryHolidayWeekday(?int $weekday): void
    {
        self::$cachedStatutoryHolidayWeekday = $weekday;
    }

    public static function holidayWeekdays(): array
    {
        if (self::$cachedHolidayWeekdays !== null) {
            return self::$cachedHolidayWeekdays;
        }

        $rule = Rule::query()->first();
        $weekdays = $rule?->holiday_weekdays;

        if (! is_array($weekdays)) {
            $weekdays = [];
        }

        return self::$cachedHolidayWeekdays = array_values(array_unique(array_map('intval', $weekdays)));
    }

    public static function setCachedHolidayWeekdays(?array $weekdays): void
    {
        self::$cachedHolidayWeekdays = $weekdays;
    }

    public static function holidayDates(): array
    {
        if (self::$cachedHolidayDates !== null) {
            return self::$cachedHolidayDates;
        }

        $dates = Rule::query()->value('holiday_dates');

        if (is_string($dates)) {
            $decoded = json_decode($dates, true);
            $dates = is_array($decoded) ? $decoded : [];
        }

        return self::$cachedHolidayDates = array_values(array_unique(array_filter((array) $dates)));
    }

    public static function setCachedHolidayDates(?array $dates): void
    {
        self::$cachedHolidayDates = $dates;
    }

    public static function annualHolidayDates(): array
    {
        if (self::$cachedAnnualHolidayDates !== null) {
            return self::$cachedAnnualHolidayDates;
        }

        $dates = Rule::query()->value('annual_holiday_dates');

        if (is_string($dates)) {
            $decoded = json_decode($dates, true);
            $dates = is_array($decoded) ? $decoded : [];
        }

        return self::$cachedAnnualHolidayDates = array_values(array_unique(array_filter((array) $dates)));
    }

    public static function setCachedAnnualHolidayDates(?array $dates): void
    {
        self::$cachedAnnualHolidayDates = $dates;
    }

    public static function isHoliday(CarbonImmutable $dateTime): bool
    {
        $businessDate = self::businessDate($dateTime);

        if (in_array($businessDate->toDateString(), self::holidayDates(), true)) {
            return true;
        }

        if (in_array($businessDate->format('m-d'), self::annualHolidayDates(), true)) {
            return true;
        }

        return in_array($businessDate->dayOfWeek, self::holidayWeekdays(), true);
    }

    public static function startOfDate(CarbonImmutable $date): CarbonImmutable
    {
        [$hour, $minute, $second] = array_pad(array_map('intval', explode(':', self::startTime())), 3, 0);

        return $date->startOfDay()->setTime($hour, $minute, $second);
    }

    public static function endOfDate(CarbonImmutable $date): CarbonImmutable
    {
        return self::startOfDate($date)->addDay();
    }

    public static function businessDate(CarbonImmutable $dateTime): CarbonImmutable
    {
        $boundary = self::startOfDate($dateTime);

        if ($dateTime->lt($boundary)) {
            return $dateTime->subDay()->startOfDay();
        }

        return $dateTime->startOfDay();
    }
}
