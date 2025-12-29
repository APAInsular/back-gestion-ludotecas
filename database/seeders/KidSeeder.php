<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kid;
use App\Models\Dni;

class KidSeeder extends Seeder
{
    public function run(): void
    {
        $dniMaria = Dni::where('dni', '12345678A')->first();
        $dniCarlos = Dni::where('dni', '87654321B')->first();

        if (!$dniMaria || !$dniCarlos) {
            return;
        }

        Kid::create([
            'name' => 'Juan',
            'birthdate' => '2018-05-12',
            'dni_id' => $dniMaria->id,
            'playroom_id' => 1,
            'tutor_id' => 3,
        ]);

        Kid::create([
            'name' => 'Juan (Padre)',
            'birthdate' => '2018-05-12',
            'dni_id' => $dniMaria->id,
            'playroom_id' => 1,
            'tutor_id' => 3,
        ]);

        Kid::create([
            'name' => 'Lucía',
            'birthdate' => '2019-09-20',
            'dni_id' => $dniCarlos->id,
            'playroom_id' => 1,
            'tutor_id' => 7,
        ]);
    }
}
