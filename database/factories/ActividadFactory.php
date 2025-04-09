<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Actividad;
use App\Models\Servicio;

class ActividadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Actividad::class;

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
            'servicio_id' => Servicio::factory(),
        ];
    }
}
