<?php

declare(strict_types=1);

namespace Modules\Shift\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Shift\Database\Factories\ScheduleFactory;

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
        'shift_draft_schedule_id',
    ];

    protected $casts = [
        'date' => 'immutable_datetime',
        'start_time' => 'immutable_datetime',
        'end_time' => 'immutable_datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function draftSchedule(): BelongsTo
    {
        return $this->BelongsTo(DraftSchedule::class, 'shift_draft_schedule_id');
    }

    public function getColStartAttribute()
    {
        $minutes = $this->start_time->hour * 60 + $this->start_time->minute;

        return intval($minutes);

    }

    public function getColSpanAttribute()
    {
        $start_minutes = $this->start_time->hour * 60 + $this->start_time->minute;
        $end_minutes = $this->end_time->hour * 60 + $this->end_time->minute;

        return intval($end_minutes - $start_minutes);
    }

    public function getViewScheduleAttribute()
    {
        return $this->start_time->format('H:i') . '~' . $this->end_time->format('H:i');
    }

    public function getDateLabelAttribute()
    {
        return $this->date->format('Y-m-d');
    }

    protected static function newFactory(): ScheduleFactory
    {
        return ScheduleFactory::new();
    }
}
