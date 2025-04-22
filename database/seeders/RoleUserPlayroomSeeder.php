<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Playroom;
use Spatie\Permission\Models\Role;

class RoleUserPlayroomSeeder extends Seeder
{
    public function run(): void
    {
        $roles     = Role::all();
        $users     = User::all();
        $playrooms = Playroom::all();

        foreach ($users as $user) {
            // Para cada usuario, asigna de 1 a 3 playrooms con un role aleatorio
            $assigned = $playrooms->random(rand(1, 3));
            foreach ($assigned as $playroom) {
                $role = $roles->random();
                $playroom->users()->syncWithoutDetaching([
                    $user->id => ['role_id' => $role->id]
                ]);
            }
        }
    }
}
