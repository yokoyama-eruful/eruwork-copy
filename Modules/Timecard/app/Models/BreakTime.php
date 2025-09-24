<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use App\Models\User;
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
        'timecard__work_time_id',
    ];

    protected $casts = [
        'date' => 'immutable_datetime',
        'in_time' => 'immutable_datetime',
        'out_time' => 'immutable_datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workTime()
    {
        return $this->belongsTo(WorkTime::class, 'timecard__work_time_id');
    }

    protected static function newFactory(): BreakTimeFactory
    {
        return BreakTimeFactory::new();
    }
}
