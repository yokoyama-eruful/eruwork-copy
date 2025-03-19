<?php

declare(strict_types=1);

namespace Modules\Timecard\Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkTimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Timecard\Models\WorkTime::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $date = CarbonImmutable::now()->subDays(rand(0, 30)); // ランダムな日付
        $inTime = $date->setTime(rand(8, 10), rand(0, 59), 0); // ランダムな出勤時間
        $outTime = $inTime->addHours(rand(7, 9))->addMinutes(rand(0, 30)); // ランダムな退勤時間

        return [
            'user_id' => rand(1, 10), // ランダムなユーザーID
            'date' => $date,
            'in_time' => $inTime,
            'out_time' => $outTime,
        ];
    }
}
