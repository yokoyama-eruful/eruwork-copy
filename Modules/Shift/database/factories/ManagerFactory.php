<?php

declare(strict_types=1);

namespace Modules\Shift\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManagerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Shift\Models\Manager::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $startDate = Carbon::now()->addMonths(rand(0, 3))->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        $submissionStartDate = $startDate->copy()->subDays(rand(7, 14));
        $submissionEndDate = $startDate->copy()->subDay();

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'submission_start_date' => $submissionStartDate,
            'submission_end_date' => $submissionEndDate,
        ];
    }
}
