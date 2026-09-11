<?php

namespace Database\Seeders;

use App\Models\CategoriaInsumo;
use Illuminate\Database\Seeder;

class CategoriaInsumoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Materia Prima Líquida', 'descripcion' => 'Agua, leche y otros líquidos base.'],
            ['nombre' => 'Edulcorantes', 'descripcion' => 'Azúcar, stevia y otros endulzantes.'],
            ['nombre' => 'Frutas y Saborizantes', 'descripcion' => 'Frutas usadas para dar sabor a kombucha y yogurt.'],
            ['nombre' => 'Cultivos y Fermentos', 'descripcion' => 'Cultivo de yogurt, té base para kombucha.'],
            ['nombre' => 'Envases y Empaques', 'descripcion' => 'Botellas y envases para el producto terminado.'],
        ];

        foreach ($categorias as $categoria) {
            CategoriaInsumo::firstOrCreate(['nombre' => $categoria['nombre']], $categoria);
        }
    }
}
