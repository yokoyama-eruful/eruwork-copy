<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\HourlyRate\Database\Factories\HourlyRateFactory;

class HourlyRate extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'rate',
        'effective_date',
    ];

    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
        ];
    }

    public function scopeCurrentRate($query, $userId)
    {
        return
            $query
                ->where('user_id', $userId)
                ->where('effective_date', '<', now())
                ->orderBy('effective_date', 'desc');
    }
}
