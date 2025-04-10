<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear roles (admin, user)
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleUser  = Role::firstOrCreate(['name' => 'user']);

        // 2. Crear usuario Admin (ajusta email/contraseña)
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'firstSurname' => 'Admin',
                'secondSurname' => 'Admin',
                'DNI' => '12345678A', // Ajusta el DNI
                'password' => Hash::make('Password2023!'), // Ajusta la contraseña
            ]
        );
        // Asignarle el rol admin
        $admin->assignRole($roleAdmin);

        // 3. Crear usuario "normal" (opcional)
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'firstSurname' => 'User',
                'secondSurname' => 'User',
                'DNI' => '87654321B', // Ajusta el DNI
                'password' => Hash::make('Password2023!'),
            ]
        );
        // Asignarle el rol user
        $user->assignRole($roleUser);

        // Otros roles o usuarios que necesites
    }
}
