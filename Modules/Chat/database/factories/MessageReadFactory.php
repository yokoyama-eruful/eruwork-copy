<?php

declare(strict_types=1);

namespace Modules\Chat\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Chat\Models\Message;

class MessageReadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Chat\Models\MessageRead::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $message = Message::find(rand(1, 50)); // ランダムなメッセージを取得
        $readAt = $this->faker->boolean(70) ? Carbon::now()->subMinutes(rand(1, 60)) : null; // 70%の確率で既読時間、30%で未読

        return [
            'message_id' => $message->id, // メッセージIDを設定
            'user_id' => rand(1, 10), // ランダムなユーザーID
            'read_at' => $readAt,
            'group_id' => $message->group_id, // メッセージからグループIDを取得して設定
        ];
    }
}
