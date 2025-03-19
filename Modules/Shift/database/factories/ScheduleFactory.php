<?php

declare(strict_types=1);

namespace Modules\Shift\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Shift\Models\Schedule::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $date = Carbon::now()->addDays(rand(0, 30))->toDateString();
        $startTime = Carbon::parse($date)->setTime(rand(8, 12), rand(0, 59), 0);
        $endTime = $startTime->copy()->addHours(rand(4, 8))->addMinutes(rand(0, 30));

        return [
            'user_id' => rand(1, 10),
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }
}
