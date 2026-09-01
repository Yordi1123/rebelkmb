<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:categorias,nombre'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'unidad_medida' => ['required', 'string', Rule::in(Categoria::UNIDADES_MEDIDA)],
        ]);

        Categoria::create($data);

        $mensaje = 'Categoría creada correctamente.';

        // Si la petición vino desde un modal dentro de otro formulario
        // (ej: formulario de producto), regresar a esa página en lugar
        // de redirigir al index de categorías.
        if ($request->boolean('_redirect_back')) {
            return back()->with('success', $mensaje);
        }

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', $mensaje);
    }

    public function edit(Categoria $categoria): View
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255', Rule::unique('categorias', 'nombre')->ignore($categoria->id)],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'unidad_medida' => ['required', 'string', Rule::in(Categoria::UNIDADES_MEDIDA)],
        ]);

        $categoria->update($data);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        if ($categoria->productos()->exists() || $categoria->tipos()->exists() || $categoria->sabores()->exists()) {
            return redirect()
                ->route('admin.categorias.index')
                ->with('error', 'No se puede eliminar: hay productos, tipos o sabores usando esta categoría.');
        }

        $categoria->delete();

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
