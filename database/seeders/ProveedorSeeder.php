<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = [
            [
                'nombre' => 'Aguas y Lácteos del Sur SAC',
                'ruc' => '20123456789',
                'direccion' => 'Av. Industrial 123, Arequipa',
                'contacto' => 'Juan Pérez - 987654321',
                'lead_time_dias' => 2,
            ],
            [
                'nombre' => 'Cristalerías del Perú',
                'ruc' => '20987654321',
                'direccion' => 'Lurín km 40, Lima',
                'contacto' => 'María Gómez - 912345678',
                'lead_time_dias' => 7,
            ],
            [
                'nombre' => 'Azucarera del Norte S.A.',
                'ruc' => '20555444333',
                'direccion' => 'Chiclayo',
                'contacto' => 'Ventas - 999888777',
                'lead_time_dias' => 4,
            ],
            [
                'nombre' => 'Agro Frutas EIRL',
                'ruc' => '20111222333',
                'direccion' => 'Mercado Mayorista',
                'contacto' => 'Pedro - 955555555',
                'lead_time_dias' => 1,
            ],
            [
                'nombre' => 'Cultivos Biológicos S.A.',
                'ruc' => '20444555666',
                'direccion' => 'Laboratorio Central, Lima',
                'contacto' => 'Dr. Ramírez - 966666666',
                'lead_time_dias' => 10,
            ]
        ];

        foreach ($proveedores as $proveedor) {
            Proveedor::firstOrCreate(['ruc' => $proveedor['ruc']], $proveedor);
        }
    }
}
