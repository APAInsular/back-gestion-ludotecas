<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'employee',
            'tutor',
            'parent',
            'manager',
            'guest',
            'supervisor',
            'coordinator',
            'monitor',
            'assistant',
            'volunteer',
            'intern',
            'director', 
            'administrator',
            'staff',
            'user',
            'member',
            'participant',
            'attendee',
            'registrant',
            'contributor',
            'supporter',
            'helper'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
