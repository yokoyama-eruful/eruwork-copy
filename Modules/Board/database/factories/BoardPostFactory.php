<?php

declare(strict_types=1);

namespace Modules\Board\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BoardPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Board\Models\BoardPost::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $statuses = ['draft', 'published', 'archived'];

        return [
            'user_id' => rand(1, 10),
            'title' => $this->faker->sentence(),
            'contents' => $this->faker->paragraphs(3, true),
            'status' => $statuses[array_rand($statuses)],
        ];
    }
}
