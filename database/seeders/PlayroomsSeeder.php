<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playroom;
use App\Models\AddressPlayroom;
use App\Models\PhonesPlayroom;
use Faker\Factory as Faker;

class PlayroomsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            // 1) Crear playroom
            $playroom = Playroom::create([
                'name'  => $faker->company . ' Playroom',
                'email' => $faker->unique()->companyEmail,
            ]);

            // 2) Crear AddressPlayroom
            $playroom->address()->create([
                'street'       => $faker->streetAddress,
                'municipality' => $faker->city,
                'locality'     => $faker->streetName,
                'zip_code'     => $faker->postcode,
                'country'      => $faker->country,
                'province'     => $faker->state,
            ]);

            // 3) Crear PhonesPlayroom
            $playroom->phones()->createMany([
                [
                    'number' => $faker->phoneNumber,
                    'label'  => 'Principal',
                ],
                [
                    'number' => $faker->phoneNumber,
                    'label'  => 'Emergencia',
                ],
            ]);
        }
    }
}
