<?php

declare(strict_types=1);

namespace Modules\Shift\Models;

use App\Models\User;
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

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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

    // protected static function newFactory(): ScheduleFactory
    // {
    //     // return ScheduleFactory::new();
    // }
}
