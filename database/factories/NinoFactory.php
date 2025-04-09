<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Ludoteca;
use App\Models\Nino;
use App\Models\Tutor;

class NinoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nino::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'birthdate' => fake()->date(),
            'ludoteca_id' => Ludoteca::factory(),
            'tutor_id' => Tutor::factory(),
        ];
    }
}
