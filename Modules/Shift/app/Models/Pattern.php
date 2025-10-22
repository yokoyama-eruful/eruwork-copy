<?php

declare(strict_types=1);

namespace Modules\Shift\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Shift\Database\Factories\ScheduleFactory;

class Pattern extends Model
{
    use HasFactory;

    protected $table = 'shift__patterns';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'immutable_datetime',
        'end_time' => 'immutable_datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
