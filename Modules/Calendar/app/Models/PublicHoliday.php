<?php

declare(strict_types=1);

namespace Modules\Calendar\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Calendar\Database\Factories\PublicHolidayFactory;

// use Modules\Calendar\Database\Factories\PublicHolidayFactory;

class PublicHoliday extends Model
{
    use HasFactory;

    protected $table = 'calendar__public_holidays';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'date',
        'name',
    ];

    protected $casts = [
        'date' => 'immutable_datetime',
    ];

    protected static function newFactory(): PublicHolidayFactory
    {
        return PublicHolidayFactory::new();
    }
}
