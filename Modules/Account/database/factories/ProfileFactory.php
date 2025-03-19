<?php

declare(strict_types=1);

namespace Modules\Account\Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Account\Models\Profile::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $birthday = CarbonImmutable::now()->subYears(rand(20, 60))->subMonths(rand(0, 11))->subDays(rand(0, 28));
        $hireDate = CarbonImmutable::now()->subYears(rand(0, 10))->subMonths(rand(0, 11))->subDays(rand(0, 28));
        $contractTypes = ['正社員', '契約社員', 'アルバイト', 'パート'];
        $relationships = ['配偶者', '親', '兄弟', '友人'];

        return [
            'user_id' => rand(1, 10),
            'icon' => $this->faker->imageUrl(),
            'name' => $this->faker->name(),
            'name_kana' => $this->faker->kanaName(),
            'contract_type' => $contractTypes[array_rand($contractTypes)],
            'post_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'birthday' => $birthday,
            'hire_date' => $hireDate,
            'emergency_name' => $this->faker->name(),
            'emergency_phone_number' => $this->faker->phoneNumber(),
            'emergency_relationship' => $relationships[array_rand($relationships)],
        ];
    }
}
