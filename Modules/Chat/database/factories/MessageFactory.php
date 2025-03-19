<?php

declare(strict_types=1);

namespace Modules\Chat\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Chat\Models\Message::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 10), // ランダムなユーザーID
            'group_id' => rand(1, 5), // ランダムなグループID
            'message' => $this->faker->sentence(), // ランダムなメッセージ
        ];
    }

    /**
     * Indicate that the message has images.
     *
     * @return Factory
     */
    public function withImages()
    {
        return $this->state(function (array $attributes) {
            return [
                'message' => null, // 画像がある場合はメッセージをnullにする
            ];
        });
    }
}
