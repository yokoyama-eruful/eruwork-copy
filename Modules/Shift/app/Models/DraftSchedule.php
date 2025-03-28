<?php

declare(strict_types=1);

namespace Modules\Shift\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Shift\Database\Factories\DraftScheduleFactory;

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

    public function getShiftStatusAttribute()
    {
        return $this->status === '承認';
    }

    public function getViewSubmissionTimeAttribute()
    {
        $startTime = (is_null($this->start_time) ? ' -- : -- ' : $this->start_time->format('H:i'));
        $endTime = (is_null($this->end_time) ? ' -- : -- ' : $this->end_time->format('H:i'));

        return $startTime . ' ～ ' . $endTime;
    }

    public function shiftSchedule(): HasOne
    {
        return $this->hasOne(Schedule::class, 'shift_draft_schedule_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDateLabelAttribute()
    {
        return $this->date->format('Y-m-d');
    }

    protected static function newFactory(): DraftScheduleFactory
    {
        return DraftScheduleFactory::new();
    }
}
