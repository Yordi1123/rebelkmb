<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Yogures', 'descripcion' => 'Línea de yogures: natural, frutado, griego y griego frutado.'],
            ['nombre' => 'Kombuchas', 'descripcion' => 'Línea de kombucha fermentada, distintos sabores.'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(['nombre' => $categoria['nombre']], $categoria);
        }
    }
}
