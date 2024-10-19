<?php

namespace Database\Factories;

use App\Models\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserStatus>
 */
class UserStatusFactory extends Factory
{
    protected $model = UserStatus::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'label' => $this->faker->word(),
            // 'data' => json_encode([]), // 必要に応じて
            // 他の必要なカラム...
        ];
    }
}
