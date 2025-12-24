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
            'night_rate' => 25,
            'pay_unit' => 1,
        ]);
    }
}
