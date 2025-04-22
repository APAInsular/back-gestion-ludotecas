<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use App\Models\Phone;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            // 1) Crear usuario
            $user = User::create([
                'name'          => $faker->firstName,
                'firstSurname'  => $faker->lastName,
                'secondSurname' => $faker->lastName,
                'email'         => $faker->unique()->safeEmail,
                'DNI'           => strtoupper($faker->bothify('########?')),
                'password'      => bcrypt('secret123'),
            ]);

            // 2) Crear Address
            $user->address()->create([
                'municipality' => $faker->city,
                'locality'     => $faker->streetName,
                'zip_code'     => $faker->postcode,
            ]);

            // 3) Crear Phone
            $user->phones()->create([
                'phone'            => $faker->numerify('6########'),
                'name'             => $faker->firstName,
                'firstSurname'     => $faker->lastName,
                'secondSurname'    => $faker->optional()->lastName,
                'emergencyContact' => $faker->boolean(30),
            ]);
        }
    }
}
