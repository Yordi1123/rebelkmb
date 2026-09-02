<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Crea los usuarios de prueba para el sistema REBEL Kombucha.
     * 
     * Solo rol administrador en esta entrega.
     * La arquitectura permite agregar planificador, operador, calidad en iteraciones futuras.
     */
    public function run(): void
    {
        // Administrador principal del sistema
        User::updateOrCreate(
            ['email' => 'admin@rebelkmb.com'],
            [
                'name'     => 'Administrador REBEL',
                'email'    => 'admin@rebelkmb.com',
                'password' => Hash::make('Rebel@2026!'), // Contraseña segura para pruebas
                'rol'      => 'administrador',
                'activo'   => true,
            ]
        );

        $this->command->info('✅ Usuario administrador creado: admin@rebelkmb.com / Rebel@2026!');
    }
}
