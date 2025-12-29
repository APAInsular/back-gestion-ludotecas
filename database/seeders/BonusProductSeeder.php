<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BonusProduct;

class BonusProductSeeder extends Seeder
{
    public function run(): void
    {
        BonusProduct::insert([
            [
                'playroom_id' => 1,
                'name' => 'Bono 1 hora',
                'minutes' => 60,
                'price' => 5,
                'active' => true,
            ],
            [
                'playroom_id' => 1,
                'name' => 'Bono 2 horas',
                'minutes' => 120,
                'price' => 9,
                'active' => true,
            ],
            [
                'playroom_id' => 1,
                'name' => 'Bono 4 horas',
                'minutes' => 240,
                'price' => 16,
                'active' => true,
            ],
        ]);
    }
}
