<?php

declare(strict_types=1);

namespace Modules\Timecard\Services;

use Carbon\CarbonImmutable;
use Modules\Timecard\Models\WorkTime;
use Modules\Timecard\Support\WorkdayBoundary;

class TimecardServices
{
    public function __construct(
        private readonly WageCalculationService $wageCalculationService
    ) {}

    public function getTimecardDataList($startDate, $endDate, int $userId): array
    {
        $startDate = CarbonImmutable::parse($startDate);
        $endDate = CarbonImmutable::parse($endDate);
        $start = WorkdayBoundary::startOfDate($startDate);
        $end = WorkdayBoundary::endOfDate($endDate);

        $workTimeList = WorkTime::query()
            ->where('user_id', $userId)
            ->whereNotNull('in_time')
            ->whereNotNull('out_time')
            ->where('in_time', '<', $end)
            ->where('out_time', '>', $start)
            ->with('breakTimes')
            ->orderBy('in_time')
            ->get();
        $user = $workTimeList->first()?->user ?? \App\Models\User::find($userId);
        $summary = $user
            ? $this->wageCalculationService->summarize($user, $startDate, $endDate)
            : ['rows' => []];

        $rows = [];
        foreach ($workTimeList as $workTime) {
            $rows[] = $this->buildRow(
                $userId,
                $workTime,
                $summary['rows'][$workTime->id] ?? [],
                $summary['rowThresholds'][$workTime->id] ?? []
            );
        }

        return $rows;
    }

    private function buildRow(int $userId, WorkTime $workTime, array $classifiedMinutes, array $thresholds): array
    {
        $workStart = CarbonImmutable::parse($workTime->in_time);
        $workEnd = CarbonImmutable::parse($workTime->out_time);
        $breaks = $workTime->breakTimes
            ->filter(fn ($break) => $break->in_time && $break->out_time)
            ->sortBy('in_time');
        $breakSummary = $this->summarizeBreakMinutes($breaks);
        $regularMinutes = $classifiedMinutes['regular'] ?? 0;
        $nightMinutes = $classifiedMinutes['night'] ?? 0;
        $overtimeMinutes = $classifiedMinutes['overtime'] ?? 0;
        $overtimeOver60Minutes = $classifiedMinutes['overtimeOver60'] ?? 0;
        $overtimeNightMinutes = $classifiedMinutes['overtimeNight'] ?? 0;
        $overtimeOver60NightMinutes = $classifiedMinutes['overtimeOver60Night'] ?? 0;
        $holidayMinutes = $classifiedMinutes['holiday'] ?? 0;
        $holidayNightMinutes = $classifiedMinutes['holidayNight'] ?? 0;

        return [
            'workTimeId' => $workTime->id,
            'userId' => $userId,
            'attendanceStartDate' => $workStart->format('Y-m-d'),
            'attendanceEndDate' => $workEnd->format('Y-m-d'),
            'attendanceStartTime' => $workStart->format('H:i'),
            'attendanceEndTime' => $workEnd->format('H:i'),
            'defaultWorkTime' => $this->formatMinutes($regularMinutes),
            'lateNightTime' => $this->formatMinutes($nightMinutes),
            'overTime' => $this->formatMinutes($overtimeMinutes),
            'overTimeOver60' => $this->formatMinutes($overtimeOver60Minutes),
            'lateNightOverTime' => $this->formatMinutes($overtimeNightMinutes),
            'lateNightOverTimeOver60' => $this->formatMinutes($overtimeOver60NightMinutes),
            'holidayWorkTime' => $this->formatMinutes($holidayMinutes),
            'holidayLateNightWorkTime' => $this->formatMinutes($holidayNightMinutes),
            'defaultBreakTime' => $this->formatMinutes($breakSummary['default']),
            'lateNightBreakTime' => $this->formatMinutes($breakSummary['lateNight']),
            'weeklyOver40' => $this->formatThresholdMinutes((int) ($thresholds['weeklyOver40'] ?? 0)),
            'monthlyOver60' => $this->formatThresholdMinutes((int) ($thresholds['monthlyOver60'] ?? 0)),
        ];
    }

    private function summarizeBreakMinutes($breaks): array
    {
        $defaultBreakMinutes = 0;
        $lateNightBreakMinutes = 0;

        foreach ($breaks as $break) {
            $segments = $this->splitByNightBoundary(
                CarbonImmutable::parse($break->in_time),
                CarbonImmutable::parse($break->out_time)
            );

            foreach ($segments as $segment) {
                if ($segment['isNight']) {
                    $lateNightBreakMinutes += $segment['minutes'];
                } else {
                    $defaultBreakMinutes += $segment['minutes'];
                }
            }
        }

        return [
            'default' => $defaultBreakMinutes,
            'lateNight' => $lateNightBreakMinutes,
        ];
    }

    private function splitByNightBoundary(CarbonImmutable $start, CarbonImmutable $end): array
    {
        $segments = [];
        $current = $start;

        while ($current->lt($end)) {
            $next = $end;
            foreach ($this->nightBoundaries($current) as $boundary) {
                if ($boundary->gt($current) && $boundary->lt($next)) {
                    $next = $boundary;
                }
            }

            $minutes = $current->diffInMinutes($next);
            if ($minutes > 0) {
                $segments[] = [
                    'minutes' => $minutes,
                    'isNight' => $this->isNight($current),
                ];
            }

            $current = $next;
        }

        return $segments;
    }

    private function nightBoundaries(CarbonImmutable $dateTime): array
    {
        return [
            $dateTime->setTime(5, 0),
            $dateTime->setTime(22, 0),
            $dateTime->addDay()->setTime(5, 0),
        ];
    }

    private function isNight(CarbonImmutable $dateTime): bool
    {
        return $dateTime->hour >= 22 || $dateTime->hour < 5;
    }

    private function formatMinutes(int|float $minutes): string
    {
        $wholeMinutes = (int) floor($minutes);

        return sprintf('%d:%02d', intdiv($wholeMinutes, 60), $wholeMinutes % 60);
    }

    private function formatThresholdMinutes(int $minutes): string
    {
        return $minutes > 0 ? $this->formatMinutes($minutes) : '';
    }
}
