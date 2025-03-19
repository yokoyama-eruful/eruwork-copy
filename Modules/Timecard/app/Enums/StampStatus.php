<?php

declare(strict_types=1);

namespace Modules\Timecard\Enums;

use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\WorkTime;

enum StampStatus: string
{
    case IN = 'in';
    case OUT = 'out';
    case BREAK_START = 'break_start';
    case BREAK_END = 'break_end';

    public static function buttonStatus(?WorkTime $workTime, ?BreakTime $breakTime): array
    {
        if (is_null($workTime) || $workTime?->out_time) {
            return [StampStatus::IN->value];
        }

        if ($workTime?->in_time) {
            if ($breakTime) {
                return [StampStatus::BREAK_END->value];
            } else {
                return [StampStatus::OUT->value, StampStatus::BREAK_START->value];
            }
        }

        return [StampStatus::OUT->value];
    }
}
