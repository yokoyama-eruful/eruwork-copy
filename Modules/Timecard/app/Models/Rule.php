<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Timecard\Database\Factories\BreakTimeFactory;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'timecard__rules';

    protected $fillable = [
        'rule',
        'workday_start_time',
        'statutory_holiday_weekday',
        'holiday_weekdays',
        'holiday_dates',
        'annual_holiday_dates',
    ];

    protected $casts = [
        'holiday_weekdays' => 'array',
        'holiday_dates' => 'array',
        'annual_holiday_dates' => 'array',
    ];
}
