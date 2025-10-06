<?php

declare(strict_types=1);

namespace Modules\Timecard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Timecard\Database\Factories\BreakTimeFactory;

class WagePremium extends Model
{
    use HasFactory;

    protected $table = 'timecard__wage_premiums';

    protected $fillable = [
        // 'fraction',
        // 'pay_unit',
        'overtime_rate',
        'night_rate',
    ];

    protected static function newFactory(): BreakTimeFactory
    {
        return BreakTimeFactory::new();
    }
}
