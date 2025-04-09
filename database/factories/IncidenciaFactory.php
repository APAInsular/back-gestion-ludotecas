<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Empleado;
use App\Models\Incidencia;

class IncidenciaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Incidencia::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'descripcion' => fake()->text(),
            'fecha' => fake()->dateTime(),
            'empleado_id' => Empleado::factory(),
        ];
    }
}
