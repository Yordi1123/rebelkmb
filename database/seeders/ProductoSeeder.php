<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $yogures = Categoria::where('nombre', 'Yogures')->firstOrFail();
        $kombuchas = Categoria::where('nombre', 'Kombuchas')->firstOrFail();

        // ------------------------------------------------------------------
        // YOGURT — datos confirmados en YOGURT-REGISTRO2026.xlsx,
        // hoja FR-RL-Y-001 (registro real de lotes de producción).
        // ------------------------------------------------------------------

        // Yogurt Natural (YN): sin sabor por definición, presentación 1L.
        Producto::firstOrCreate(
            ['codigo' => 'YN-001'],
            [
                'nombre' => 'Yogurt Natural',
                'categoria_id' => $yogures->id,
                'tipo' => 'yogurt_natural',
                'sabor' => null,
                'presentacion' => '1L',
                'unidad_medida' => 'litros',
                'activo' => true,
            ]
        );

        // Yogurt Griego (YG): sin sabor (version simple), presentacion 1L.
        Producto::firstOrCreate(
            ['codigo' => 'YG-001'],
            [
                'nombre' => 'Yogurt Griego',
                'categoria_id' => $yogures->id,
                'tipo' => 'yogurt_griego',
                'sabor' => null,
                'presentacion' => '1L',
                'unidad_medida' => 'litros',
                'activo' => true,
            ]
        );

        // Yogurt Frutado (YF): presentacion 1L, sabores confirmados en el registro de lotes.
        $saboresYF = ['Arándanos', 'Maracuyá', 'Mango', 'Maracuyá-Mango'];

        foreach ($saboresYF as $index => $sabor) {
            Producto::firstOrCreate(
                ['codigo' => 'YF-'.str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
                [
                    'nombre' => "Yogurt Frutado {$sabor}",
                    'categoria_id' => $yogures->id,
                    'tipo' => 'yogurt_frutado',
                    'sabor' => $sabor,
                    'presentacion' => '1L',
                    'unidad_medida' => 'litros',
                    'activo' => true,
                ]
            );
        }

        // Yogurt Griego Frutado (YGF): presentacion 150ml, sabores confirmados.
        $saboresYGF = ['Maracuyá-Mango', 'Arándanos', 'Fresa'];

        foreach ($saboresYGF as $index => $sabor) {
            Producto::firstOrCreate(
                ['codigo' => 'YGF-'.str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
                [
                    'nombre' => "Yogurt Griego Frutado {$sabor}",
                    'categoria_id' => $yogures->id,
                    'tipo' => 'yogurt_griego_frutado',
                    'sabor' => $sabor,
                    'presentacion' => '150ml',
                    'unidad_medida' => 'mililitros',
                    'activo' => true,
                ]
            );
        }

        // ------------------------------------------------------------------
        // KOMBUCHA — sabores confirmados en KOMBUCHA-REGISTRO_2026.xlsx.
        // Presentacion 330ml confirmada por el catalogo publico de la marca.
        // ------------------------------------------------------------------
        $saboresKombucha = [
            'Fresa',
            'Coca Muña',
            'Maracuyá',
            'Arándanos',
            'Piña Jengibre',
            'Hierba Luisa',
        ];

        foreach ($saboresKombucha as $index => $sabor) {
            Producto::firstOrCreate(
                ['codigo' => 'KB-'.str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
                [
                    'nombre' => "Kombucha {$sabor}",
                    'categoria_id' => $kombuchas->id,
                    'tipo' => 'kombucha',
                    'sabor' => $sabor,
                    'presentacion' => '330ml',
                    'unidad_medida' => 'mililitros',
                    'activo' => true,
                ]
            );
        }
    }
}
