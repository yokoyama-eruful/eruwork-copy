<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Modules\Timecard\Enums\StampStatus;

class Stamp
{
    public static function push(CarbonImmutable $datetime, StampStatus $status): void
    {
        $workTime =
            WorkTime::where('user_id', Auth::id())
                ->whereDate('date', $datetime)
                ->whereNull('out_time')
                ->orderBy('in_time', 'desc')
                ->first();

        switch ($status) {
            case StampStatus::IN:
                self::in($datetime, $workTime);
                break;
            case StampStatus::OUT:
                self::out($datetime, $workTime);
                break;
            case StampStatus::BREAK_START:
                self::breakStart($datetime, $workTime);
                break;
            case StampStatus::BREAK_END:
                self::breakEnd($datetime, $workTime);
                break;
        }
    }

    private static function in(CarbonImmutable $datetime, ?WorkTime $workTime): void
    {
        if ($workTime?->in_time) {
            abort(400, '出社中です。退勤ボタンを押してください。');
        }

        $params = [
            'user_id' => Auth::id(),
            'date' => $datetime->format('Y-m-d'),
            'in_time' => $datetime->format('H:i'),
        ];

        WorkTime::create($params);
    }

    private static function out(CarbonImmutable $datetime, ?WorkTime $workTime): void
    {
        if (is_null($workTime)) {
            abort(400, '出勤状態ではありません。');
        }

        $workTime->update([
            'out_time' => $datetime->format('H:i'),
        ]);
    }

    private static function breakStart(CarbonImmutable $datetime, ?WorkTime $workTime): void
    {
        if (is_null($workTime)) {
            abort(400, '出勤状態ではありません。');
        }

        $breakTime =
            BreakTime::query()
                ->where('user_id', Auth::id())
                ->whereDate('date', $datetime)
                ->whereNull('out_time')
                ->orderBy('in_time', 'desc')
                ->first();

        if ($breakTime) {
            abort(400, '休憩中です。');
        }

        BreakTime::create([
            'user_id' => Auth::id(),
            'date' => $workTime->date,
            'in_time' => $datetime->format('H:i'),
        ]);
    }

    private static function breakEnd(CarbonImmutable $datetime, ?WorkTime $workTime): void
    {
        if (is_null($workTime)) {
            abort(400, '出勤状態ではありません。');
        }

        $breakTime =
            BreakTime::query()
                ->where('user_id', Auth::id())
                ->whereDate('date', $datetime)
                ->whereNotNull('in_time')
                ->whereNull('out_time')
                ->orderBy('in_time', 'desc')
                ->first();

        if (is_null($breakTime)) {
            abort(400, '休憩を開始してください。');
        }

        $breakTime->update([
            'out_time' => $datetime->format('H:i'),
        ]);

    }
}
