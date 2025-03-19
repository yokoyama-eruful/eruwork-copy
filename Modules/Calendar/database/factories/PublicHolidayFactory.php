<?php

declare(strict_types=1);

namespace Modules\Calendar\Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicHolidayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Calendar\Models\PublicHoliday::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $holidays = [
            ['date' => '2025-01-01', 'name' => '元日'],
            ['date' => '2025-01-13', 'name' => '成人の日'],
            ['date' => '2025-02-11', 'name' => '建国記念の日'],
            ['date' => '2025-02-23', 'name' => '天皇誕生日'],
            ['date' => '2025-03-20', 'name' => '春分の日'],
            ['date' => '2025-04-29', 'name' => '昭和の日'],
            ['date' => '2025-05-03', 'name' => '憲法記念日'],
            ['date' => '2025-05-04', 'name' => 'みどりの日'],
            ['date' => '2025-05-05', 'name' => 'こどもの日'],
            ['date' => '2025-07-21', 'name' => '海の日'],
            ['date' => '2025-08-11', 'name' => '山の日'],
            ['date' => '2025-09-15', 'name' => '敬老の日'],
            ['date' => '2025-09-23', 'name' => '秋分の日'],
            ['date' => '2025-10-13', 'name' => 'スポーツの日'],
            ['date' => '2025-11-03', 'name' => '文化の日'],
            ['date' => '2025-11-23', 'name' => '勤労感謝の日'],
            // 必要に応じて、2026年の祝日を追加 (重複しないように注意)
        ];

        $holiday = $holidays[array_rand($holidays)];

        return [
            'date' => CarbonImmutable::parse($holiday['date']),
            'name' => $holiday['name'],
        ];
    }
}
