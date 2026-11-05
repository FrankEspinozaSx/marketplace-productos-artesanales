<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'artesano@marketplace.pe'],
            [
                'name' => 'Frank Espinoza (Artesano)',
                'rol' => 'artesano',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'comprador@marketplace.pe'],
            [
                'name' => 'Ana Gomez (Compradora)',
                'rol' => 'comprador',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
