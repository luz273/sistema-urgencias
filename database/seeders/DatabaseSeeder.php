<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <- IMPORTAR HASH

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Crear administrador
        User::create([
            'name' => 'Admin MedAlert',
            'email' => 'admin@urgencias.com',
            'password' => Hash::make('12345678'),
            'role' => 'administrador',
        ]);
    }
}
