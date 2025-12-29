<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Crear rol superadmin si no existe
        $superAdminRole = Role::firstOrCreate([
            'name' => 'superadmin',
        ]);

        // 2️⃣ Lista de desarrolladores (puedes añadir más)
        $developers = [
            [
                'name'          => 'Soporte',
                'firstSurname'  => 'Platita',
                'secondSurname' => 'Software',
                'email'         => 'hola@platita.es',
                'DNI'           => '00000000X',
                'password'      => Hash::make(env('SUPERADMIN_PASSWORD')),
            ],
        ];

        foreach ($developers as $dev) {
            $user = User::firstOrCreate(
                ['email' => $dev['email']],
                $dev
            );

            // 3️⃣ Asignar rol superadmin
            if (!$user->hasRole('superadmin')) {
                $user->assignRole($superAdminRole);
            }
        }
    }
}
