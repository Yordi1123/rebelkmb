<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Sabor;
use App\Models\Tipo;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $yogures = Categoria::where('nombre', 'Yogures')->firstOrFail();
        $kombuchas = Categoria::where('nombre', 'Kombuchas')->firstOrFail();

        $tipoYN = Tipo::where('codigo', 'YN')->firstOrFail();
        $tipoYF = Tipo::where('codigo', 'YF')->firstOrFail();
        $tipoYG = Tipo::where('codigo', 'YG')->firstOrFail();
        $tipoYGF = Tipo::where('codigo', 'YGF')->firstOrFail();
        $tipoKB = Tipo::where('codigo', 'KB')->firstOrFail();

        // Yogurt Natural: sin sabor.
        Producto::firstOrCreate(
            ['nombre' => 'Yogurt Natural', 'tipo_id' => $tipoYN->id],
            [
                'categoria_id' => $yogures->id,
                'sabor_id' => null,
                'presentacion' => '1L',
                'unidad_medida' => 'litros',
                'activo' => true,
            ]
        );

        // Yogurt Griego: sin sabor.
        Producto::firstOrCreate(
            ['nombre' => 'Yogurt Griego', 'tipo_id' => $tipoYG->id],
            [
                'categoria_id' => $yogures->id,
                'sabor_id' => null,
                'presentacion' => '1L',
                'unidad_medida' => 'litros',
                'activo' => true,
            ]
        );

        // Yogurt Frutado: presentación 1L, sabores confirmados en el registro de lotes.
        $saboresYF = ['Arándanos', 'Maracuyá', 'Mango', 'Maracuyá-Mango'];

        foreach ($saboresYF as $nombreSabor) {
            $sabor = Sabor::where('nombre', $nombreSabor)->where('categoria_id', $yogures->id)->firstOrFail();

            Producto::firstOrCreate(
                ['tipo_id' => $tipoYF->id, 'sabor_id' => $sabor->id],
                [
                    'nombre' => "Yogurt Frutado {$nombreSabor}",
                    'categoria_id' => $yogures->id,
                    'presentacion' => '1L',
                    'unidad_medida' => 'litros',
                    'activo' => true,
                ]
            );
        }

        // Yogurt Griego Frutado: presentación 150ml, sabores confirmados.
        $saboresYGF = ['Maracuyá-Mango', 'Arándanos', 'Fresa'];

        foreach ($saboresYGF as $nombreSabor) {
            $sabor = Sabor::where('nombre', $nombreSabor)->where('categoria_id', $yogures->id)->firstOrFail();

            Producto::firstOrCreate(
                ['tipo_id' => $tipoYGF->id, 'sabor_id' => $sabor->id],
                [
                    'nombre' => "Yogurt Griego Frutado {$nombreSabor}",
                    'categoria_id' => $yogures->id,
                    'presentacion' => '150ml',
                    'unidad_medida' => 'mililitros',
                    'activo' => true,
                ]
            );
        }

        // Kombucha: 6 sabores confirmados, presentación 330ml.
        $saboresKombucha = ['Fresa', 'Coca Muña', 'Maracuyá', 'Arándanos', 'Piña Jengibre', 'Hierba Luisa'];

        foreach ($saboresKombucha as $nombreSabor) {
            $sabor = Sabor::where('nombre', $nombreSabor)->where('categoria_id', $kombuchas->id)->firstOrFail();

            Producto::firstOrCreate(
                ['tipo_id' => $tipoKB->id, 'sabor_id' => $sabor->id],
                [
                    'nombre' => "Kombucha {$nombreSabor}",
                    'categoria_id' => $kombuchas->id,
                    'presentacion' => '330ml',
                    'unidad_medida' => 'mililitros',
                    'activo' => true,
                ]
            );
        }
    }
}
