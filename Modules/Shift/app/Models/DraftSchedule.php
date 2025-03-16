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
        'manager_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function getViewSubmissionTimeAttribute()
    {
        return (is_null($this->start_time) ? ' -- : -- ' : $this->start_time->format('H:i')) . ' ～ ' . (is_null($this->end_time) ? ' -- : -- ' : $this->end_time->format('H:i'));
    }
}
