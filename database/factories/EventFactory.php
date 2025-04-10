<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Playroom;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'date' => fake()->dateTime(),
            'hour' => fake()->time(),
            'description' => fake()->text(),
            'location' => fake()->word(),
            'playroom_id' => Playroom::factory(),
        ];
    }
}
