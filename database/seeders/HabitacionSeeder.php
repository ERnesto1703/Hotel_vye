<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitacion;

class HabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 15 Habitaciones Estándar (101 - 115)
        for ($i = 101; $i <= 115; $i++) {
            Habitacion::create([
                'numero' => 'Habitación ' . $i,
                'tipo' => 'estandar',
                'precio' => 120.00,
                'estado' => 'disponible',
            ]);
        }

        // 15 Habitaciones Familiar (201 - 215)
        for ($i = 201; $i <= 215; $i++) {
            Habitacion::create([
                'numero' => 'Habitación ' . $i,
                'tipo' => 'familiar',
                'precio' => 180.00,
                'estado' => 'disponible',
            ]);
        }

        // 10 Habitaciones Premium (301 - 310)
        for ($i = 301; $i <= 310; $i++) {
            Habitacion::create([
                'numero' => 'Suite ' . $i,
                'tipo' => 'premium',
                'precio' => 280.00,
                'estado' => 'disponible',
            ]);
        }
    }
}
