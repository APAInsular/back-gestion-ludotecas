<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Configuracion;
use App\Models\Usuario;

class ConfiguracionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Configuracion::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'idioma' => fake()->word(),
            'notificaciones' => fake()->boolean(),
            'usuario_id' => Usuario::factory(),
        ];
    }
}
