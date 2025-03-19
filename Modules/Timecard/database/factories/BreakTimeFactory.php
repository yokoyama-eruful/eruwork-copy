<?php

declare(strict_types=1);

namespace Modules\Timecard\Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class BreakTimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Timecard\Models\BreakTime::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $date = CarbonImmutable::now()->subDays(rand(0, 30));
        $inTime = $date->setTime(rand(12, 13), rand(0, 59), 0);
        $outTime = $inTime->addMinutes(rand(15, 60));

        return [
            'user_id' => rand(1, 10),
            'date' => $date,
            'in_time' => $inTime,
            'out_time' => $outTime,
        ];
    }
}
