<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid'=>fake()->unique()->numerify,
            'first_name' => fake()->firstName(),
            'last_name' =>fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }

}
