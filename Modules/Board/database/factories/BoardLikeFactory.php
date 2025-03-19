<?php

declare(strict_types=1);

namespace Modules\Board\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BoardLikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Board\Models\BoardLike::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 10),
            'post_id' => rand(1, 50), // 50件のpostがある場合
        ];
    }
}
