<?php

namespace Database\Seeders;

use App\Models\CategoriaInsumo;
use App\Models\Insumo;
use Illuminate\Database\Seeder;

class InsumoSeeder extends Seeder
{
    /**
     * Insumos confirmados EXCLUSIVAMENTE en los 8 diagramas DOP revisados:
     * DOP-KBS-01 (Kombucha Madre/Starter), DOP-KBA-001, DOP-KBCM-0001,
     * DOP-KBHL-001, DOP-KBF-001, DOP-KBM-001, DOP-KBPJ-001, DOP-YGF-01.
     */
    public function run(): void
    {
        $liquida = CategoriaInsumo::where('nombre', 'Materia Prima Líquida')->firstOrFail();
        $edulcorantes = CategoriaInsumo::where('nombre', 'Edulcorantes')->firstOrFail();
        $frutas = CategoriaInsumo::where('nombre', 'Frutas y Saborizantes')->firstOrFail();
        $cultivos = CategoriaInsumo::where('nombre', 'Cultivos y Fermentos')->firstOrFail();
        $envases = CategoriaInsumo::where('nombre', 'Envases y Empaques')->firstOrFail();
        $aditivos = CategoriaInsumo::where('nombre', 'Aditivos y Conservantes')->firstOrFail();

        $insumos = [
            // ----------------------------------------------------------
            // Materia Prima Líquida (DOP-YGF-01: Leche y Leche UHT son
            // dos entradas distintas en el diagrama, no la misma cosa)
            // ----------------------------------------------------------
            ['codigo' => 'AGUA', 'nombre' => 'Agua', 'categoria_insumo_id' => $liquida->id, 'unidad_medida' => 'litros', 'stock_minimo' => 50, 'stock_seguridad' => 20],
            ['codigo' => 'LECHE', 'nombre' => 'Leche', 'categoria_insumo_id' => $liquida->id, 'unidad_medida' => 'litros', 'stock_minimo' => 30, 'stock_seguridad' => 10],
            ['codigo' => 'LECHE-UHT', 'nombre' => 'Leche UHT', 'categoria_insumo_id' => $liquida->id, 'unidad_medida' => 'litros', 'stock_minimo' => 10, 'stock_seguridad' => 5],

            // ----------------------------------------------------------
            // Edulcorantes (todos los DOP de kombucha: "Disolución de la sacarosa")
            // ----------------------------------------------------------
            ['codigo' => 'AZUC', 'nombre' => 'Azúcar', 'categoria_insumo_id' => $edulcorantes->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 10, 'stock_seguridad' => 5],

            // ----------------------------------------------------------
            // Frutas y Saborizantes (uno por cada DOP de sabor de kombucha;
            // Piña y Jengibre separados porque el diagrama los lista como
            // dos ingredientes distintos: "...con piña y jengibre")
            // ----------------------------------------------------------
            ['codigo' => 'FR-ARA', 'nombre' => 'Arándanos', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
            ['codigo' => 'FR-CM', 'nombre' => 'Coca Muña', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 3, 'stock_seguridad' => 1],
            ['codigo' => 'FR-HL', 'nombre' => 'Hierba Luisa', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 2, 'stock_seguridad' => 1],
            ['codigo' => 'FR-FRE', 'nombre' => 'Fresa', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
            ['codigo' => 'FR-MAR', 'nombre' => 'Maracuyá', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
            ['codigo' => 'FR-PIN', 'nombre' => 'Piña', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 3, 'stock_seguridad' => 1],
            ['codigo' => 'FR-JEN', 'nombre' => 'Jengibre', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 2, 'stock_seguridad' => 1],

            // ----------------------------------------------------------
            // Cultivos y Fermentos
            // ----------------------------------------------------------
            ['codigo' => 'CULT-Y', 'nombre' => 'Cultivo Yogurt', 'categoria_insumo_id' => $cultivos->id, 'unidad_medida' => 'gramos', 'stock_minimo' => 100, 'stock_seguridad' => 50],
            ['codigo' => 'TE-NEG', 'nombre' => 'Té negro', 'categoria_insumo_id' => $cultivos->id, 'unidad_medida' => 'gramos', 'stock_minimo' => 200, 'stock_seguridad' => 100],
            // Scooby: cultivo base con el que se fabrica la Kombucha Madre (DOP-KBS-01).
            ['codigo' => 'SCOOBY', 'nombre' => 'Scooby', 'categoria_insumo_id' => $cultivos->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 1, 'stock_seguridad' => 0],
            // Kombucha Madre / Starter: PRODUCTO INTERMEDIO, no se compra a ningún
            // proveedor. Se fabrica internamente (DOP-KBS-01: Scooby + Azúcar +
            // Agua + Té, 40-50 días de fermentación) y luego se usa como insumo
            // "Scooby + biopelícula (Starter)" en cada receta de sabor.
            ['codigo' => 'KBMADRE', 'nombre' => 'Kombucha Madre (Starter)', 'categoria_insumo_id' => $cultivos->id, 'unidad_medida' => 'litros', 'stock_minimo' => 10, 'stock_seguridad' => 5],

            // ----------------------------------------------------------
            // Envases y Empaques
            // ----------------------------------------------------------
            ['codigo' => 'BOT330', 'nombre' => 'Botella 330ml', 'categoria_insumo_id' => $envases->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 200, 'stock_seguridad' => 100],
            ['codigo' => 'CHAPA', 'nombre' => 'Chapas (tapas botella)', 'categoria_insumo_id' => $envases->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 200, 'stock_seguridad' => 100],
            ['codigo' => 'ENV150', 'nombre' => 'Envase 150ml', 'categoria_insumo_id' => $envases->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 100, 'stock_seguridad' => 50],

            // ----------------------------------------------------------
            // Aditivos y Conservantes (DOP-YGF-01: "suero + natamicina al 0,2%")
            // ----------------------------------------------------------
            ['codigo' => 'NATAM', 'nombre' => 'Natamicina', 'categoria_insumo_id' => $aditivos->id, 'unidad_medida' => 'gramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
        ];

        foreach ($insumos as $insumo) {
            Insumo::firstOrCreate(
                ['codigo' => $insumo['codigo']],
                [...$insumo, 'stock_actual' => 0, 'activo' => true]
            );
        }
    }
}
