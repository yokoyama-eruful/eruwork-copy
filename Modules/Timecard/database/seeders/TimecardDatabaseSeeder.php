<?php

declare(strict_types=1);

namespace Modules\Timecard\Database\Seeders;

use Illuminate\Database\Seeder;

class TimecardDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RuleSeeder::class,
            WagePremiumSeeder::class,
        ]);
    }
}
