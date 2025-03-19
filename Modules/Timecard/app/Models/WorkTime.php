<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Timecard\Database\Factories\WorkTimeFactory;

// use Modules\Timecard\Database\Factories\AttendanceFactory;

class WorkTime extends Model
{
    use HasFactory;

    protected $table = 'timecard__work_times';

    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'date',
        'in_time',
        'out_time',
    ];

    protected $casts = [
        'date' => 'immutable_datetime',
        'in_time' => 'immutable_datetime',
        'out_time' => 'immutable_datetime',
    ];

    protected static function newFactory(): WorkTimeFactory
    {
        return WorkTimeFactory::new();
    }
}
