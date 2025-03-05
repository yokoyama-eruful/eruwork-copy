<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Timecard\Database\Factories\AttendanceFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'timecard__attendances';

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

    public function breakTimes()
    {
        return $this->hasMany(BreakTime::class);
    }

    public function getBreakTimeListAttribute()
    {
        return $this->breakTimes()->orderBy('start_time')->get();
    }
}
