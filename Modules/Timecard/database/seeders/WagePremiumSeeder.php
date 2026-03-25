<?php

declare(strict_types=1);

namespace Modules\Timecard\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Timecard\Models\WagePremium;

class WagePremiumSeeder extends Seeder
{
    public function run(): void
    {
        WagePremium::create([
            'overtime_rate' => 35,
            'overtime_over_60_rate' => 50,
            'night_rate' => 25,
            'holiday_rate' => 35,
            'pay_unit' => 1,
        ]);
    }
}
