<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Configuration;
use App\Models\User;

class ConfigurationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Configuration::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'language' => fake()->word(),
            'notifications' => fake()->boolean(),
            'user_id' => User::factory(),
        ];
    }
}
