<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Playroom;

class PlayroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Playroom::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'address' => fake()->word(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password(),
        ];
    }
}
