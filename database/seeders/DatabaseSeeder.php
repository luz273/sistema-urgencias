<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Solo crear el admin si no existe
        User::firstOrCreate(
            ['email' => 'admin@urgencias.com'],
            [
                'name' => 'Admin MedAlert',
                'password' => Hash::make('12345678'),
                'role' => 'administrador',
            ]
        );
    }
}