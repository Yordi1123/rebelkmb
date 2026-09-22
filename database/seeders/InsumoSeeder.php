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

        // Obtener proveedores de prueba
        $pAguas = \App\Models\Proveedor::where('nombre', 'Aguas y Lácteos del Sur SAC')->first();
        $pCristal = \App\Models\Proveedor::where('nombre', 'Cristalerías del Perú')->first();
        $pAzucar = \App\Models\Proveedor::where('nombre', 'Azucarera del Norte S.A.')->first();
        $pAgro = \App\Models\Proveedor::where('nombre', 'Agro Frutas EIRL')->first();
        $pCultivos = \App\Models\Proveedor::where('nombre', 'Cultivos Biológicos S.A.')->first();

        $insumos = [
            // ----------------------------------------------------------
            // Materia Prima Líquida
            // ----------------------------------------------------------
            ['codigo' => 'AGUA', 'nombre' => 'Agua', 'categoria_insumo_id' => $liquida->id, 'proveedor_id' => $pAguas?->id, 'unidad_medida' => 'litros', 'stock_minimo' => 50, 'stock_seguridad' => 20],
            ['codigo' => 'LECHE', 'nombre' => 'Leche', 'categoria_insumo_id' => $liquida->id, 'proveedor_id' => $pAguas?->id, 'unidad_medida' => 'litros', 'stock_minimo' => 30, 'stock_seguridad' => 10],
            ['codigo' => 'LECHE-UHT', 'nombre' => 'Leche UHT', 'categoria_insumo_id' => $liquida->id, 'proveedor_id' => $pAguas?->id, 'unidad_medida' => 'litros', 'stock_minimo' => 10, 'stock_seguridad' => 5],

            // ----------------------------------------------------------
            // Edulcorantes
            // ----------------------------------------------------------
            ['codigo' => 'AZUC', 'nombre' => 'Azúcar', 'categoria_insumo_id' => $edulcorantes->id, 'proveedor_id' => $pAzucar?->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 10, 'stock_seguridad' => 5],

            // ----------------------------------------------------------
            // Frutas y Saborizantes
            // ----------------------------------------------------------
            ['codigo' => 'FR-ARA', 'nombre' => 'Arándanos', 'categoria_insumo_id' => $frutas->id, 'proveedor_id' => $pAgro?->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
            ['codigo' => 'FR-CM', 'nombre' => 'Coca Muña', 'categoria_insumo_id' => $frutas->id, 'proveedor_id' => $pAgro?->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 3, 'stock_seguridad' => 1],
            ['codigo' => 'FR-HL', 'nombre' => 'Hierba Luisa', 'categoria_insumo_id' => $frutas->id, 'proveedor_id' => $pAgro?->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 2, 'stock_seguridad' => 1],
            ['codigo' => 'FR-FRE', 'nombre' => 'Fresa', 'categoria_insumo_id' => $frutas->id, 'proveedor_id' => $pAgro?->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
            ['codigo' => 'FR-MAR', 'nombre' => 'Maracuyá', 'categoria_insumo_id' => $frutas->id, 'proveedor_id' => $pAgro?->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
            ['codigo' => 'FR-PIN', 'nombre' => 'Piña', 'categoria_insumo_id' => $frutas->id, 'proveedor_id' => $pAgro?->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 3, 'stock_seguridad' => 1],
            ['codigo' => 'FR-JEN', 'nombre' => 'Jengibre', 'categoria_insumo_id' => $frutas->id, 'proveedor_id' => $pAgro?->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 2, 'stock_seguridad' => 1],

            // ----------------------------------------------------------
            // Cultivos y Fermentos
            // ----------------------------------------------------------
            ['codigo' => 'CULT-Y', 'nombre' => 'Cultivo Yogurt', 'categoria_insumo_id' => $cultivos->id, 'proveedor_id' => $pCultivos?->id, 'unidad_medida' => 'gramos', 'stock_minimo' => 100, 'stock_seguridad' => 50],
            ['codigo' => 'TE-NEG', 'nombre' => 'Té negro', 'categoria_insumo_id' => $cultivos->id, 'proveedor_id' => $pCultivos?->id, 'unidad_medida' => 'gramos', 'stock_minimo' => 200, 'stock_seguridad' => 100],
            ['codigo' => 'SCOOBY', 'nombre' => 'Scooby', 'categoria_insumo_id' => $cultivos->id, 'proveedor_id' => $pCultivos?->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 1, 'stock_seguridad' => 0],
            // Starter no tiene proveedor porque se fabrica in-house
            ['codigo' => 'KBMADRE', 'nombre' => 'Kombucha Madre (Starter)', 'categoria_insumo_id' => $cultivos->id, 'proveedor_id' => null, 'unidad_medida' => 'litros', 'stock_minimo' => 10, 'stock_seguridad' => 5],

            // ----------------------------------------------------------
            // Envases y Empaques
            // ----------------------------------------------------------
            ['codigo' => 'BOT330', 'nombre' => 'Botella 330ml', 'categoria_insumo_id' => $envases->id, 'proveedor_id' => $pCristal?->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 200, 'stock_seguridad' => 100],
            ['codigo' => 'CHAPA', 'nombre' => 'Chapas (tapas botella)', 'categoria_insumo_id' => $envases->id, 'proveedor_id' => $pCristal?->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 200, 'stock_seguridad' => 100],
            ['codigo' => 'ENV150', 'nombre' => 'Envase 150ml', 'categoria_insumo_id' => $envases->id, 'proveedor_id' => $pCristal?->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 100, 'stock_seguridad' => 50],

            // ----------------------------------------------------------
            // Aditivos y Conservantes
            // ----------------------------------------------------------
            ['codigo' => 'NATAM', 'nombre' => 'Natamicina', 'categoria_insumo_id' => $aditivos->id, 'proveedor_id' => $pCultivos?->id, 'unidad_medida' => 'gramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
        ];

        foreach ($insumos as $insumo) {
            Insumo::firstOrCreate(
                ['codigo' => $insumo['codigo']],
                [...$insumo, 'stock_actual' => 0, 'activo' => true]
            );
        }
    }
}
