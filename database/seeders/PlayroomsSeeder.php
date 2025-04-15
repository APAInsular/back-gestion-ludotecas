<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Playroom;          // Ajusta a tu namespace
use App\Models\AddressPlayroom;   // Ajusta a tu namespace
use App\Models\PhonesPlayroom;    // Ajusta a tu namespace

class PlayroomsSeeder extends Seeder
{
    public function run()
    {
        // Array con 10 ludotecas y sus datos de dirección y teléfonos
        $playroomsData = [
            [
                'playroom' => [
                    'name' => 'Ludoteca Central',
                    'email' => 'central@playroom.test',
                ],
                'address' => [
                    'street' => 'Calle Mayor 100',
                    'municipality' => 'Madrid',
                    'locality' => 'Centro',
                    'zip_code' => '28001',
                    'country' => 'España',
                    'province' => 'Madrid',
                ],
                'phones' => [
                    [
                        'number' => '600111222',
                        'label' => 'Principal'
                    ],
                    [
                        'number' => '600333444',
                        'label' => 'Emergencia'
                    ]
                ]
            ],
            [
                'playroom' => [
                    'name' => 'Ludoteca Arcoiris',
                    'email' => 'arcoiris@playroom.test',
                ],
                'address' => [
                    'street' => 'Avenida de la Luz 12',
                    'municipality' => 'Barcelona',
                    'locality' => 'Eixample',
                    'zip_code' => '08002',
                    'country' => 'España',
                    'province' => 'Barcelona',
                ],
                'phones' => [
                    [
                        'number' => '600555666',
                        'label' => 'Principal'
                    ]
                ]
            ],
            [
                'playroom' => [
                    'name' => 'Ludoteca Aventureros',
                    'email' => 'aventureros@playroom.test',
                ],
                'address' => [
                    'street' => 'Camino del Bosque 9',
                    'municipality' => 'Valencia',
                    'locality' => 'Extramurs',
                    'zip_code' => '46001',
                    'country' => 'España',
                    'province' => 'Valencia',
                ],
                'phones' => [
                    [
                        'number' => '600777888',
                        'label' => 'Principal'
                    ],
                    [
                        'number' => '600999000',
                        'label' => 'Emergencia'
                    ]
                ]
            ],
            [
                'playroom' => [
                    'name' => 'Ludoteca Fantasía',
                    'email' => 'fantasia@playroom.test',
                ],
                'address' => [
                    'street' => 'Calle Encantada 3',
                    'municipality' => 'Sevilla',
                    'locality' => 'Casco Antiguo',
                    'zip_code' => '41001',
                    'country' => 'España',
                    'province' => 'Sevilla',
                ],
                'phones' => [
                    [
                        'number' => '601111222',
                        'label' => 'Principal'
                    ]
                ]
            ],
            [
                'playroom' => [
                    'name' => 'Ludoteca Exploradores',
                    'email' => 'exploradores@playroom.test',
                ],
                'address' => [
                    'street' => 'Calle del Río 45',
                    'municipality' => 'Bilbao',
                    'locality' => 'Abando',
                    'zip_code' => '48001',
                    'country' => 'España',
                    'province' => 'Bizkaia',
                ],
                'phones' => [
                    [
                        'number' => '601333444',
                        'label' => 'Principal'
                    ],
                    [
                        'number' => '601555666',
                        'label' => 'Información'
                    ]
                ]
            ],
            [
                'playroom' => [
                    'name' => 'Ludoteca Pequeños Gigantes',
                    'email' => 'pequenos@playroom.test',
                ],
                'address' => [
                    'street' => 'Plaza de la Infancia 7',
                    'municipality' => 'Granada',
                    'locality' => 'Centro',
                    'zip_code' => '18001',
                    'country' => 'España',
                    'province' => 'Granada',
                ],
                'phones' => [
                    [
                        'number' => '601777888',
                        'label' => 'Principal'
                    ]
                ]
            ],
            [
                'playroom' => [
                    'name' => 'Ludoteca Norte',
                    'email' => 'norte@playroom.test',
                ],
                'address' => [
                    'street' => 'Carretera del Norte 21',
                    'municipality' => 'Santander',
                    'locality' => 'Cuatro Caminos',
                    'zip_code' => '39001',
                    'country' => 'España',
                    'province' => 'Cantabria',
                ],
                'phones' => [
                    [
                        'number' => '602111222',
                        'label' => 'Principal'
                    ],
                    [
                        'number' => '602333444',
                        'label' => 'Emergencia'
                    ]
                ]
            ],
            [
                'playroom' => [
                    'name' => 'Ludoteca Estrella',
                    'email' => 'estrella@playroom.test',
                ],
                'address' => [
                    'street' => 'Avenida de la Estrella 25',
                    'municipality' => 'Zaragoza',
                    'locality' => 'Casco Histórico',
                    'zip_code' => '50001',
                    'country' => 'España',
                    'province' => 'Zaragoza',
                ],
                'phones' => [
                    [
                        'number' => '602555666',
                        'label' => 'Principal'
                    ]
                ]
            ],
            [
                'playroom' => [
                    'name' => 'Ludoteca Peques Felices',
                    'email' => 'peques@playroom.test',
                ],
                'address' => [
                    'street' => 'Calle Colores 10',
                    'municipality' => 'Málaga',
                    'locality' => 'Centro',
                    'zip_code' => '29001',
                    'country' => 'España',
                    'province' => 'Málaga',
                ],
                'phones' => [
                    [
                        'number' => '602777888',
                        'label' => 'Principal'
                    ],
                    [
                        'number' => '602999000',
                        'label' => 'Información'
                    ]
                ]
            ],
            [
                'playroom' => [
                    'name' => 'Ludoteca Oeste',
                    'email' => 'oeste@playroom.test',
                ],
                'address' => [
                    'street' => 'Camino del Oeste 15',
                    'municipality' => 'Valladolid',
                    'locality' => 'Parquesol',
                    'zip_code' => '47001',
                    'country' => 'España',
                    'province' => 'Valladolid',
                ],
                'phones' => [
                    [
                        'number' => '603111222',
                        'label' => 'Principal'
                    ]
                ]
            ],
        ];

        // Transacción para crear cada playroom, su address y sus phones
        DB::transaction(function () use ($playroomsData) {
            foreach ($playroomsData as $data) {
                // 1) Crear la playroom
                $playroom = Playroom::create([
                    'name' => $data['playroom']['name'],
                    'email' => $data['playroom']['email'],
                    // Si tienes más campos en playrooms, agrégalos aquí
                ]);

                // 2) Crear dirección (addresses_playroom)
                $playroom->address()->create([
                    'street' => $data['address']['street'],
                    'municipality' => $data['address']['municipality'],
                    'locality' => $data['address']['locality'],
                    'zip_code' => $data['address']['zip_code'],
                    'country' => $data['address']['country'],
                    'province' => $data['address']['province'],
                ]);

                // 3) Crear teléfonos en phones_playroom
                if (!empty($data['phones'])) {
                    $playroom->phones()->createMany($data['phones']);
                }
            }
        });
    }
}
