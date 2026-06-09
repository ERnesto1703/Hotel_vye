<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Camioneta;

class CamionetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Camioneta::create([
            'placa' => 'ABC-123',
            'capacidad' => 6,
        ]);

        Camioneta::create([
            'placa' => 'DEF-456',
            'capacidad' => 8,
        ]);

        Camioneta::create([
            'placa' => 'GHI-789',
            'capacidad' => 10,
        ]);
    }
}
