<?php

declare(strict_types=1);

namespace Modules\Board\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BoardAttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Board\Models\BoardAttachment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'file_path' => $this->faker->filePath(),
            'file_name' => $this->faker->word() . '.' . $this->faker->fileExtension(),
            'post_id' => rand(1, 50), // 50件のpostがある場合
        ];
    }
}
