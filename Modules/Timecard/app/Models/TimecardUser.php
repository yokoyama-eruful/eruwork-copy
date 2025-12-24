<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// use Modules\Timecard\Database\Factories\BreakTimeFactory;

class TimecardUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'timecard__users';

    protected $fillable = [
        'pin_encrypted',
    ];
}
