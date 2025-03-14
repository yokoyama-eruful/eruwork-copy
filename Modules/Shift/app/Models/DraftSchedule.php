<?php

declare(strict_types=1);

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Shift\Database\Factories\DraftScheduleFactory;

class DraftSchedule extends Model
{
    use HasFactory;

    protected $table = 'shift__draft_schedules';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'managers_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    // protected static function newFactory(): DraftScheduleFactory
    // {
    //     // return DraftScheduleFactory::new();
    // }
}
