<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Los seeders se ejecutan en orden de dependencia FK:
     * primero los catálogos maestros, luego los usuarios.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
        ]);
    }
}
