<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Activity;
use App\Models\Service;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'date' => fake()->dateTime(),
            'hour' => fake()->time(),
            'description' => fake()->text(),
            'service_id' => Service::factory(),
        ];
    }
}
