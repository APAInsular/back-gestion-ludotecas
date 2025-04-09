<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Evento;
use App\Models\Ludoteca;

class EventoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Evento::class;

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
            'ludoteca_id' => Ludoteca::factory(),
        ];
    }
}
