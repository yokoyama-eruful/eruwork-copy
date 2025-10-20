<?php

declare(strict_types=1);

namespace Modules\Shift\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Shift\Database\Factories\ManagerFactory;

// use Modules\Shift\Database\Factories\モManagersFactory;

class Manager extends Model
{
    use HasFactory;

    protected $table = 'shift__managers';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'submission_start_date',
        'submission_end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'submission_start_date' => 'date',
        'submission_end_date' => 'date',
    ];

    public function getViewScheduleAttribute()
    {
        return $this->start_date->format('Y.m.d') . '~' . $this->end_date->format('Y.m.d');
    }

    public function getViewSubmissionScheduleAttribute()
    {
        return $this->submission_start_date->format('Y.m.d') . '~' . $this->submission_end_date->format('Y.m.d');
    }

    public function getOverSubmissionPeriodAttribute()
    {
        return Carbon::parse($this->submission_end_date)->endOfDay()->gte(now());
    }

    public function getReceptionStatusAttribute(): string
    {
        if ($this->submission_start_date > now()) {
            return '準備中';
        }

        if (
            $this->submission_start_date <= now() &&
            $this->submission_end_date->endOfDay() >= now()
        ) {
            return '受付中';
        }

        return '終了';
    }

    protected static function newFactory(): ManagerFactory
    {
        return ManagerFactory::new();
    }
}
