<?php

declare(strict_types=1);

use App\Models\User;
use Carbon\CarbonImmutable;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\WorkTime;

class totalWorkingTimeDto
{
    public static function month(User $user, CarbonImmutable $date): string
    {
        // 準備
        $startOfMonth = $date->startOfMonth();
        $endOfMonth = $date->endOfMonth();

        $workTimes = WorkTime::query()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('user_id', $user->id)
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->get();

        $breakTimes = BreakTime::query()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('user_id', $user->id)
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->get();

        //　処理
        $totalWorkTime = $workTimes
            ->sum(function ($workTime) {
                return $workTime->in_time->diffInMinutes($workTime->out_time);
            });

        $totalBreakTime = $breakTimes
            ->sum(function ($breakTime) {
                return $breakTime->in_time->diffInMinutes($breakTime->out_time);
            });

        $totalMinutes = $totalWorkTime - $totalBreakTime;

        //　出力
        return sprintf('%01d時間%02d分', floor($totalMinutes / 60), $totalMinutes % 60);
    }
}
