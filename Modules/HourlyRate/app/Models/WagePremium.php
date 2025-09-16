<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\HourlyRate\Database\Factories\HourlyRateFactory;

class WagePremium extends Model
{
    use HasFactory;

    // テーブル名
    protected $table = 'wage_premiums';

    // 変更可能なカラム
    protected $fillable = [
        'name',
        'rate',
        'start_time',
        'end_time',
        'day_of_week',
        'is_holiday',
    ];

    // 割増率をパーセントで取得するアクセサ
    public function getRatePercentAttribute()
    {
        return $this->rate . '%';
    }

    // 深夜・早朝・休日などを判定する便利メソッド
    public function isNight(): bool
    {
        $now = now()->format('H:i');

        return $this->start_time && $this->end_time &&
               (
                   ($this->start_time <= $now && $now < '24:00') ||
                   ($now >= '00:00' && $now < $this->end_time)
               );
    }

    public function isEarlyMorning(): bool
    {
        $now = now()->format('H:i');

        return $this->start_time && $this->end_time &&
               ($this->start_time <= $now && $now < $this->end_time);
    }
}
