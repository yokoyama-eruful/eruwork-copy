<?php

declare(strict_types=1);

namespace Modules\Shift\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Shift\Database\Factories\モManagersFactory;

class Managers extends Model
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

    // protected static function newFactory(): モManagersFactory
    // {
    //     // return モManagersFactory::new();
    // }
}
