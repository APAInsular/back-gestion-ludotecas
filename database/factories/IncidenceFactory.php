<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Incidence;

class IncidenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Incidence::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'description' => fake()->text(),
            'date' => fake()->dateTime(),
            'employee_id' => Employee::factory(),
        ];
    }
}
