<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Timecard\Database\Factories\BreakTimeFactory;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'timecard__rules';

    protected $fillable = [
        'rule',
    ];
}
