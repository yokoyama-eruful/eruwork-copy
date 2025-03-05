<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Timecard\Database\Factories\BreakTimeFactory;

class BreakTime extends Model
{
    use HasFactory;

    protected $table = 'timecard__break_times';

    protected $fillable = [
        'attendance_id',
        'user_id',
        'date',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'date' => 'immutable_datetime',
        'start_time' => 'immutable_datetime',
        'end_time' => 'immutable_datetime',
    ];

    public function attendance()
    {
        return $this->hasOne(Attendance::class, 'attendance_id');
    }
}
