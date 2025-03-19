<?php

declare(strict_types=1);

namespace Modules\Chat\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Chat\Models\Group::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $isDm = $this->faker->boolean();
        $name = $isDm ? null : $this->faker->sentence(3); // DMなら名前はnull、グループならランダムな文字列
        $icon = $this->faker->imageUrl(640, 480, 'people', true); // ランダムな画像URL

        return [
            'is_dm' => $isDm,
            'name' => $name,
            'icon' => $icon,
        ];
    }
}
