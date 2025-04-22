<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Asociar los primeros 5 usuarios como empleados
        User::take(5)->get()->each(function ($user) use ($faker) {
            Employee::create([
                'user_id'      => $user->id,
                'position'     => $faker->jobTitle,
                'salary'       => $faker->randomFloat(2, 1200, 5000),
                'bank_account'=> $faker->bothify('ES####################'),
            ]);
        });
    }
}
