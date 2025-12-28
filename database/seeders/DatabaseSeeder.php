<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Versión simplificada para evitar errores de columnas faltantes
        User::updateOrCreate(
            ['email' => 'admin@urgencias.com'],
            [
                'name' => 'Admin MedAlert',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}