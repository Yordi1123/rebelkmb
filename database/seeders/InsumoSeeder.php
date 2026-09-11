<?php

namespace Database\Seeders;

use App\Models\CategoriaInsumo;
use App\Models\Insumo;
use Illuminate\Database\Seeder;

class InsumoSeeder extends Seeder
{
    public function run(): void
    {
        $liquida = CategoriaInsumo::where('nombre', 'Materia Prima Líquida')->firstOrFail();
        $edulcorantes = CategoriaInsumo::where('nombre', 'Edulcorantes')->firstOrFail();
        $frutas = CategoriaInsumo::where('nombre', 'Frutas y Saborizantes')->firstOrFail();
        $cultivos = CategoriaInsumo::where('nombre', 'Cultivos y Fermentos')->firstOrFail();
        $envases = CategoriaInsumo::where('nombre', 'Envases y Empaques')->firstOrFail();

        // stock_actual y proveedor_id quedan sin datos reales todavia (0 y null).
        // stock_minimo/stock_seguridad son valores de ejemplo para que el
        // equipo los ajuste segun la operacion real.
        $insumos = [
            ['codigo' => 'AGUA', 'nombre' => 'Agua', 'categoria_insumo_id' => $liquida->id, 'unidad_medida' => 'litros', 'stock_minimo' => 50, 'stock_seguridad' => 20],
            ['codigo' => 'LECHE', 'nombre' => 'Leche', 'categoria_insumo_id' => $liquida->id, 'unidad_medida' => 'litros', 'stock_minimo' => 30, 'stock_seguridad' => 10],

            ['codigo' => 'AZUC', 'nombre' => 'Azúcar', 'categoria_insumo_id' => $edulcorantes->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 10, 'stock_seguridad' => 5],
            ['codigo' => 'STEV', 'nombre' => 'Stevia', 'categoria_insumo_id' => $edulcorantes->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 2, 'stock_seguridad' => 1],

            ['codigo' => 'FR-FRE', 'nombre' => 'Fresa', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
            ['codigo' => 'FR-CM', 'nombre' => 'Coca Muña', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 3, 'stock_seguridad' => 1],
            ['codigo' => 'FR-MAR', 'nombre' => 'Maracuyá', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
            ['codigo' => 'FR-ARA', 'nombre' => 'Arándanos', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],
            ['codigo' => 'FR-PIN', 'nombre' => 'Piña', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 3, 'stock_seguridad' => 1],
            ['codigo' => 'FR-JEN', 'nombre' => 'Jengibre', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 2, 'stock_seguridad' => 1],
            ['codigo' => 'FR-HL', 'nombre' => 'Hierba Luisa', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 2, 'stock_seguridad' => 1],
            ['codigo' => 'FR-MAN', 'nombre' => 'Mango', 'categoria_insumo_id' => $frutas->id, 'unidad_medida' => 'kilogramos', 'stock_minimo' => 5, 'stock_seguridad' => 2],

            ['codigo' => 'CULT-Y', 'nombre' => 'Cultivo Yogurt', 'categoria_insumo_id' => $cultivos->id, 'unidad_medida' => 'gramos', 'stock_minimo' => 100, 'stock_seguridad' => 50],
            ['codigo' => 'TE-KB', 'nombre' => 'Té (base kombucha)', 'categoria_insumo_id' => $cultivos->id, 'unidad_medida' => 'gramos', 'stock_minimo' => 200, 'stock_seguridad' => 100],

            ['codigo' => 'BOT330', 'nombre' => 'Botella 330ml', 'categoria_insumo_id' => $envases->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 200, 'stock_seguridad' => 100],
            ['codigo' => 'BOT1L', 'nombre' => 'Botella 1L', 'categoria_insumo_id' => $envases->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 100, 'stock_seguridad' => 50],
            ['codigo' => 'ENV150', 'nombre' => 'Envase 150ml', 'categoria_insumo_id' => $envases->id, 'unidad_medida' => 'unidades', 'stock_minimo' => 100, 'stock_seguridad' => 50],
        ];

        foreach ($insumos as $insumo) {
            Insumo::firstOrCreate(
                ['codigo' => $insumo['codigo']],
                [...$insumo, 'stock_actual' => 0, 'activo' => true]
            );
        }
    }
}
