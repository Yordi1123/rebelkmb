<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Insumo;
use Illuminate\Support\Facades\DB;

class BomSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Obtener insumos
        $leche = Insumo::where('codigo', 'LECHE')->firstOrFail();
        $lecheUht = Insumo::where('codigo', 'LECHE-UHT')->firstOrFail();
        $cultivo = Insumo::where('codigo', 'CULT-Y')->firstOrFail();
        $envase1L = Insumo::where('codigo', 'ENV1L')->firstOrFail();
        $envase150 = Insumo::where('codigo', 'ENV150')->firstOrFail();
        $chapa = Insumo::where('codigo', 'CHAPA')->firstOrFail();
        $etiqueta = Insumo::where('codigo', 'ETIQ')->firstOrFail();
        $ygBase = Insumo::where('codigo', 'YG-BASE')->firstOrFail();
        $natamicina = Insumo::where('codigo', 'NATAM')->firstOrFail();
        $suero = Insumo::where('codigo', 'SUERO')->firstOrFail();

        // 2. Obtener productos
        $yg1L = Producto::where('nombre', 'Yogurt Griego')->where('presentacion', '1L')->firstOrFail();
        
        $productosYGF = Producto::where('nombre', 'like', 'Yogurt Griego Frutado%')->get();
        $productosYF = Producto::where('nombre', 'like', 'Yogurt Frutado%')->get();

        // 3. Poblar BOM para Yogurt Griego (1L)
        $bomYG = [
            ['material_id' => $leche->id, 'cantidad_requerida' => 1.5, 'unidad_medida' => 'Litros', 'etapa' => 'Recepción', 'tipo' => 'consumo'],
            ['material_id' => $lecheUht->id, 'cantidad_requerida' => 0.05, 'unidad_medida' => 'Litros', 'etapa' => 'Mezcla inoculante', 'tipo' => 'consumo'],
            ['material_id' => $cultivo->id, 'cantidad_requerida' => 10, 'unidad_medida' => 'Gramos', 'etapa' => 'Mezcla inoculante', 'tipo' => 'consumo'],
            ['material_id' => $suero->id, 'cantidad_requerida' => 0.5, 'unidad_medida' => 'Litros', 'etapa' => 'Desuerado', 'tipo' => 'subproducto'],
            ['material_id' => $suero->id, 'cantidad_requerida' => 0.1, 'unidad_medida' => 'Litros', 'etapa' => 'Preparación del conservante', 'tipo' => 'consumo'],
            ['material_id' => $natamicina->id, 'cantidad_requerida' => 0.5, 'unidad_medida' => 'Gramos', 'etapa' => 'Preparación del conservante', 'tipo' => 'consumo'],
            ['material_id' => $envase1L->id, 'cantidad_requerida' => 1, 'unidad_medida' => 'Unidades', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
            ['material_id' => $chapa->id, 'cantidad_requerida' => 1, 'unidad_medida' => 'Unidades', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
            ['material_id' => $etiqueta->id, 'cantidad_requerida' => 1, 'unidad_medida' => 'Unidades', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
        ];

        foreach ($bomYG as $item) {
            DB::table('bom')->updateOrInsert(
                ['producto_id' => $yg1L->id, 'material_id' => $item['material_id']],
                array_merge($item, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // 4. Poblar BOM para Yogurt Griego Frutado (150ml) por sabor
        foreach ($productosYGF as $ygf) {
            $nombreSabor = $ygf->sabor->nombre; // Ej: Fresa, Arándanos
            // Determinar código de mermelada
            $codigoMermelada = 'MERM-' . strtoupper(substr($nombreSabor, 0, 3));
            if ($nombreSabor === 'Maracuyá-Mango') $codigoMermelada = 'MERM-MM';
            
            $mermelada = Insumo::where('codigo', $codigoMermelada)->first();
            
            if (!$mermelada) continue;

            $bomYGF = [
                ['material_id' => $ygBase->id, 'cantidad_requerida' => 135, 'unidad_medida' => 'Gramos', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
                ['material_id' => $envase150->id, 'cantidad_requerida' => 1, 'unidad_medida' => 'Unidades', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
                ['material_id' => $chapa->id, 'cantidad_requerida' => 1, 'unidad_medida' => 'Unidades', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
                ['material_id' => $etiqueta->id, 'cantidad_requerida' => 1, 'unidad_medida' => 'Unidades', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
                ['material_id' => $mermelada->id, 'cantidad_requerida' => 15, 'unidad_medida' => 'Gramos', 'etapa' => 'Batido y Frutado', 'tipo' => 'consumo'],
            ];

            foreach ($bomYGF as $item) {
                DB::table('bom')->updateOrInsert(
                    ['producto_id' => $ygf->id, 'material_id' => $item['material_id']],
                    array_merge($item, ['created_at' => now(), 'updated_at' => now()])
                );
            }
        }

        // 5. Poblar BOM para Yogurt Frutado (1L) por sabor
        foreach ($productosYF as $yf) {
            $nombreSabor = $yf->sabor->nombre;
            $codigoMermelada = 'MERM-' . strtoupper(substr($nombreSabor, 0, 3));
            if ($nombreSabor === 'Maracuyá-Mango') $codigoMermelada = 'MERM-MM';
            if ($nombreSabor === 'Mango') $codigoMermelada = 'MERM-MAN'; // Para no confundir con Maracuyá
            if ($nombreSabor === 'Maracuyá') $codigoMermelada = 'MERM-MAR';
            
            $mermelada = Insumo::where('codigo', $codigoMermelada)->first();
            
            if (!$mermelada) continue;

            $bomYF = [
                ['material_id' => $leche->id, 'cantidad_requerida' => 0.9, 'unidad_medida' => 'Litros', 'etapa' => 'Recepción', 'tipo' => 'consumo'],
                ['material_id' => $lecheUht->id, 'cantidad_requerida' => 0.05, 'unidad_medida' => 'Litros', 'etapa' => 'Mezcla inoculante', 'tipo' => 'consumo'],
                ['material_id' => $cultivo->id, 'cantidad_requerida' => 10, 'unidad_medida' => 'Gramos', 'etapa' => 'Mezcla inoculante', 'tipo' => 'consumo'],
                ['material_id' => $suero->id, 'cantidad_requerida' => 0.1, 'unidad_medida' => 'Litros', 'etapa' => 'Preparación del conservante', 'tipo' => 'consumo'],
                ['material_id' => $natamicina->id, 'cantidad_requerida' => 0.5, 'unidad_medida' => 'Gramos', 'etapa' => 'Preparación del conservante', 'tipo' => 'consumo'],
                ['material_id' => $mermelada->id, 'cantidad_requerida' => 100, 'unidad_medida' => 'Gramos', 'etapa' => 'Batido y Frutado', 'tipo' => 'consumo'],
                ['material_id' => $envase1L->id, 'cantidad_requerida' => 1, 'unidad_medida' => 'Unidades', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
                ['material_id' => $chapa->id, 'cantidad_requerida' => 1, 'unidad_medida' => 'Unidades', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
                ['material_id' => $etiqueta->id, 'cantidad_requerida' => 1, 'unidad_medida' => 'Unidades', 'etapa' => 'Envasado', 'tipo' => 'consumo'],
            ];

            foreach ($bomYF as $item) {
                DB::table('bom')->updateOrInsert(
                    ['producto_id' => $yf->id, 'material_id' => $item['material_id']],
                    array_merge($item, ['created_at' => now(), 'updated_at' => now()])
                );
            }
        }
    }
}
