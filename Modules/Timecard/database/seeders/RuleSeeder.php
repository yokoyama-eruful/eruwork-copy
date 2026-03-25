<?php

declare(strict_types=1);

namespace Modules\Timecard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Timecard\Models\Rule;

class RuleSeeder extends Seeder
{
    public function run(): void
    {
        Rule::create([
            'rule' => 'personal',
            'workday_start_time' => '00:00:00',
            'statutory_holiday_weekday' => 0,
            'holiday_weekdays' => [0],
            'holiday_dates' => [],
            'annual_holiday_dates' => [],
        ]);
    }
}
