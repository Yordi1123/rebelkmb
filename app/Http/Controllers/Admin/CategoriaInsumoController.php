<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaInsumo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class CategoriaInsumoController extends Controller
{
    public function index(): View
    {
        $categorias = CategoriaInsumo::orderBy('nombre')->get();

        return view('admin.categorias_insumo.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('admin.categorias_insumo.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:255', 'unique:categorias_insumo,nombre'],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ]);

        $categoria = CategoriaInsumo::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $categoria
            ]);
        }

        // Si la petición viene del modal dentro del formulario de insumo,
        // volvemos a la página anterior para que el nuevo registro aparezca
        // disponible en el select sin perder los datos ya ingresados.
        if ($request->boolean('_redirect_back')) {
            return redirect()->back()->with('success', 'Categoría creada correctamente.');
        }

        return redirect()
            ->route('admin.categorias-insumo.index')
            ->with('success', 'Categoría de insumo creada correctamente.');
    }

    public function edit(CategoriaInsumo $categoria_insumo): View
    {
        return view('admin.categorias_insumo.edit', ['categoria' => $categoria_insumo]);
    }

    public function update(Request $request, CategoriaInsumo $categoria_insumo): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255', Rule::unique('categorias_insumo', 'nombre')->ignore($categoria_insumo->id)],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ]);

        $categoria_insumo->update($data);

        return redirect()
            ->route('admin.categorias-insumo.index')
            ->with('success', 'Categoría de insumo actualizada correctamente.');
    }

    public function destroy(CategoriaInsumo $categoria_insumo): RedirectResponse
    {
        if ($categoria_insumo->insumos()->exists()) {
            return redirect()
                ->route('admin.categorias-insumo.index')
                ->with('error', 'No se puede eliminar: hay insumos usando esta categoría.');
        }

        $categoria_insumo->delete();

        return redirect()
            ->route('admin.categorias-insumo.index')
            ->with('success', 'Categoría de insumo eliminada correctamente.');
    }
}
