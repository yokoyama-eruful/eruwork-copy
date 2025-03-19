<?php

declare(strict_types=1);

namespace Modules\Chat\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Chat\Models\MessageImage::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'message_id' => rand(1, 50), // ランダムなメッセージID (例: 50件のメッセージがある場合)
            'file_path' => $this->faker->imageUrl(), // ランダムな画像URL
        ];
    }
}
