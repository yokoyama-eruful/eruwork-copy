<?php

declare(strict_types=1);

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Shift\Database\Factories\ScheduleFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'shift__schedules';

    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time',
    ];

    // protected static function newFactory(): ScheduleFactory
    // {
    //     // return ScheduleFactory::new();
    // }
}
