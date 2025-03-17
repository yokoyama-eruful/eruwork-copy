<?php

declare(strict_types=1);

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->start_date->format('Y年m月d日') . '~' . $this->end_date->format('Y年m月d日');
    }

    public function getViewSubmissionScheduleAttribute()
    {
        return $this->submission_start_date->format('Y年m月d日') . '~' . $this->submission_end_date->format('Y年m月d日');
    }

    // protected static function newFactory(): ManagersFactory
    // {
    //     // return モManagersFactory::new();
    // }
}
