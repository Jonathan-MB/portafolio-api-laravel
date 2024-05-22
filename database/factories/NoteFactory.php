<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function Laravel\Prompts\text;


class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3,true),
            'text' => fake()->paragraph(500),
            'user_id' => fake()->numberBetween(1,10),
            'state_id' => fake()->numberBetween(1,2),
            'visibility_id' => fake()->numberBetween(1,2),
            'updated_at' => now(),
            'created_at' => now(),        ];
    }
}
