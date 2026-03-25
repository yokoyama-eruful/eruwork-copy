<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Carbon\CarbonImmutable;
use Modules\Timecard\Enums\StampStatus;

class Stamp
{
    public static function push(CarbonImmutable $datetime, StampStatus $status, int $userId): void
    {
        $workTime = WorkTime::where('user_id', $userId)
            ->whereNull('out_time')
            ->orderBy('in_time', 'desc')
            ->first();

        switch ($status) {
            case StampStatus::IN:
                self::in($datetime, $workTime, $userId);
                break;
            case StampStatus::OUT:
                self::out($datetime, $workTime);
                break;
            case StampStatus::BREAK_START:
                self::breakStart($datetime, $workTime, $userId);
                break;
            case StampStatus::BREAK_END:
                self::breakEnd($datetime, $workTime, $userId);
                break;
        }
    }

    private static function in(CarbonImmutable $datetime, ?WorkTime $workTime, int $userId): void
    {
        if ($workTime?->in_time) {
            abort(400, '出社中です。退勤ボタンを押してください。');
        }

        $pay_unit = WagePremium::first()->pay_unit ?? 1;

        $calculated = self::roundInTime($datetime, $pay_unit);

        WorkTime::create([
            'user_id' => $userId,
            'in_time' => $calculated->format('Y-m-d H:i'),
        ]);
    }

    private static function out(CarbonImmutable $datetime, ?WorkTime $workTime): void
    {
        if (is_null($workTime)) {
            abort(400, '出勤状態ではありません。');
        }

        $pay_unit = WagePremium::first()->pay_unit ?? 1;

        $calculated = self::roundOutTime($datetime, $pay_unit);

        $inTime = CarbonImmutable::parse($workTime->in_time);

        if ($calculated->lessThan($inTime)) {
            $calculated = $inTime;
        }

        $workTime->update([
            'out_time' => $calculated->format('Y-m-d H:i'),
        ]);
    }

    private static function roundInTime(CarbonImmutable $datetime, int $pay_unit): CarbonImmutable
    {
        if ($pay_unit === 1) {
            return $datetime;
        }

        $minute = $datetime->minute;

        $roundedMinute = intdiv($minute, $pay_unit) * $pay_unit;

        if ($minute % $pay_unit !== 0) {
            $roundedMinute += $pay_unit;
        }

        return $datetime->setMinute($roundedMinute)->setSecond(0);
    }

    private static function roundOutTime(CarbonImmutable $datetime, int $pay_unit): CarbonImmutable
    {
        if ($pay_unit === 1) {
            return $datetime;
        }

        $minute = $datetime->minute;

        $roundedMinute = intdiv($minute, $pay_unit) * $pay_unit;

        return $datetime->setMinute($roundedMinute)->setSecond(0);
    }

    private static function breakStart(CarbonImmutable $datetime, ?WorkTime $workTime, int $userId): void
    {
        if (is_null($workTime)) {
            abort(400, '出勤状態ではありません。');
        }

        $breakTime = BreakTime::where('user_id', $userId)
            ->where('timecard__work_time_id', $workTime->id)
            ->whereNull('out_time')
            ->orderBy('in_time', 'desc')
            ->first();

        if ($breakTime) {
            abort(400, '休憩中です。');
        }

        BreakTime::create([
            'user_id' => $userId,
            'timecard__work_time_id' => $workTime->id,
            'in_time' => $datetime->format('Y-m-d H:i'),
        ]);
    }

    private static function breakEnd(CarbonImmutable $datetime, ?WorkTime $workTime, int $userId): void
    {
        if (is_null($workTime)) {
            abort(400, '出勤状態ではありません。');
        }

        $breakTime = BreakTime::where('user_id', $userId)
            ->where('timecard__work_time_id', $workTime->id)
            ->whereNotNull('in_time')
            ->whereNull('out_time')
            ->orderBy('in_time', 'desc')
            ->first();

        if (is_null($breakTime)) {
            abort(400, '休憩を開始してください。');
        }

        $breakTime->update([
            'out_time' => $datetime->format('Y-m-d H:i'),
        ]);

    }
}
