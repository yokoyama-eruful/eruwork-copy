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
        ]);
    }
}
