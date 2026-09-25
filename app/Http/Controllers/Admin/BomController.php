<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BomController extends Controller
{
    /**
     * Mostrar la receta (BOM) de un producto.
     */
    public function index(Producto $producto)
    {
        // Cargar insumos agrupados por etapa para la UI visual
        $bomItems = $producto->insumos()->withPivot('id', 'cantidad_requerida', 'unidad_medida', 'etapa', 'tipo')->get();
        
        // Agrupar por etapa, manteniendo un orden lógico si es posible
        // Como las etapas son texto libre en BD, agrupamos exactamente por el texto
        $etapas = $bomItems->groupBy('pivot.etapa');
        
        // Insumos disponibles para agregar (que no estén ya en la receta)
        $insumosAgregadosIds = $bomItems->pluck('id')->toArray();
        $insumosDisponibles = Insumo::whereNotIn('id', $insumosAgregadosIds)
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.productos.bom', compact('producto', 'etapas', 'insumosDisponibles'));
    }

    /**
     * Añadir un nuevo insumo a la receta.
     */
    public function store(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'material_id' => [
                'required',
                'exists:materiales,id',
                Rule::unique('bom')->where(function ($query) use ($producto) {
                    return $query->where('producto_id', $producto->id);
                })
            ],
            'cantidad_requerida' => 'required|numeric|min:0.0001',
            'etapa' => 'required|string|max:100',
            'tipo' => 'required|in:consumo,subproducto',
        ]);

        $insumo = Insumo::findOrFail($validated['material_id']);

        $producto->insumos()->attach($insumo->id, [
            'cantidad_requerida' => $validated['cantidad_requerida'],
            'unidad_medida' => $insumo->unidad_medida, // Copiar unidad del insumo
            'etapa' => $validated['etapa'],
            'tipo' => $validated['tipo'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Insumo agregado a la receta correctamente.');
    }

    /**
     * Actualizar cantidad o etapa de un insumo en la receta.
     */
    public function update(Request $request, Producto $producto, $bomId)
    {
        $validated = $request->validate([
            'cantidad_requerida' => 'required|numeric|min:0.0001',
            'etapa' => 'required|string|max:100',
            'tipo' => 'required|in:consumo,subproducto',
        ]);

        DB::table('bom')
            ->where('id', $bomId)
            ->where('producto_id', $producto->id) // Asegurar pertenencia
            ->update([
                'cantidad_requerida' => $validated['cantidad_requerida'],
                'etapa' => $validated['etapa'],
                'tipo' => $validated['tipo'],
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Insumo de receta actualizado.');
    }

    /**
     * Eliminar un insumo de la receta.
     */
    public function destroy(Producto $producto, $bomId)
    {
        DB::table('bom')
            ->where('id', $bomId)
            ->where('producto_id', $producto->id)
            ->delete();

        return back()->with('success', 'Insumo eliminado de la receta.');
    }
}
