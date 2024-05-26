<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(45),
            'email' => fake()->unique()->safeEmail(),
            'rol_id' => fake()->numberBetween(1,2),
            'password' => Hash::make($this->faker->password(6,10)) ,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }

}
