<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dni;

class DniSeeder extends Seeder
{
    public function run(): void
    {
        Dni::create([
            'dni' => '12345678A',
            'name' => 'María',
            'surname' => 'Pérez',
            'phone' => '600111222',
            'email' => 'maria.perez@email.com',
        ]);

        Dni::create([
            'dni' => '87654321B',
            'name' => 'Carlos',
            'surname' => 'Gómez',
            'phone' => '600333444',
            'email' => 'carlos.gomez@email.com',
        ]);

        Dni::create([
            'dni' => '11223344C',
            'name' => 'Laura',
            'surname' => 'Rodríguez',
            'phone' => '600555666',
            'email' => 'laura.rodriguez@email.com',
        ]);
    }
}
