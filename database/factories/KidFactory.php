<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Kid;
use App\Models\Playroom;
use App\Models\Tutor;

class KidFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kid::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'birthdate' => fake()->date(),
            'playroom_id' => Playroom::factory(),
            'tutor_id' => Tutor::factory(),
        ];
    }
}
