<?php

declare(strict_types=1);

namespace Modules\Calendar\Actions;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Modules\Calendar\Models\Schedule;
use Modules\Shift\Models\Schedule as ShiftSchedule;

class CalendarManager
{
    // ユーザー名でグループ化
    public static function getShifts(CarbonImmutable $startDate, CarbonImmutable $endDate)
    {
        $shifts =
            ShiftSchedule::whereBetween('date', [$startDate, $endDate])
                ->get();

        $period = CarbonPeriodImmutable::create($startDate, $endDate);

        $items = [];
        foreach ($period as $date) {
            $items[$date->format('Y-m-d')]
                = $shifts
                    ->where('date', $date)
                    ->groupBy(function ($shift) {
                        return $shift->user->name;
                    });
        }

        return $items;
    }

    public static function getMyShiftSchedule(CarbonImmutable $startDate, CarbonImmutable $endDate)
    {
        $shifts =
        ShiftSchedule::where('user_id', Auth::id())
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('start_time')
            ->get();

        $period = CarbonPeriodImmutable::create($startDate, $endDate);

        $items = [];
        foreach ($period as $date) {
            $itemList = [
                $shifts->where('date', $date),
            ];

            $items[$date->format('Y-m-d')] = self::itemsConcat($itemList);
        }

        return $items;
    }

    public static function getSchedule(CarbonImmutable $startDate, CarbonImmutable $endDate)
    {

        $schedules =
            Schedule::where('user_id', Auth::id())
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('start_time')
                ->get();

        $period = CarbonPeriodImmutable::create($startDate, $endDate);

        $items = [];
        foreach ($period as $date) {
            $itemList = [
                $schedules->where('date', $date),
            ];

            $items[$date->format('Y-m-d')] = self::itemsConcat($itemList);
        }

        return $items;
    }

    private static function itemsConcat($collections)
    {
        $combined = array_shift($collections);

        foreach ($collections as $collection) {
            $combined = $combined->concat($collection);
        }

        return $combined;
    }
}
