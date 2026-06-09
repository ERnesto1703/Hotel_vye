<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Only seed if Habitacion table is empty
        if (\App\Models\Habitacion::count() === 0) {
            $this->call([
                HabitacionSeeder::class,
                CamionetaSeeder::class,
            ]);
        }
    }
}
