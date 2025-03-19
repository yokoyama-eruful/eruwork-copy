<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Timecard\Database\Factories\BreakTimeFactory;

// use Modules\Timecard\Database\Factories\BreakTimeFactory;

class BreakTime extends Model
{
    use HasFactory;

    protected $table = 'timecard__break_times';

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

    public function attendance()
    {
        return $this->hasOne(WorkTime::class, 'attendance_id');
    }

    protected static function newFactory(): BreakTimeFactory
    {
        return BreakTimeFactory::new();
    }
}
