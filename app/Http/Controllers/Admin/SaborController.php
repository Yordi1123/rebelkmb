<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Sabor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class SaborController extends Controller
{
    public function index(): View
    {
        $sabores    = Sabor::with('categoria')->orderBy('nombre')->get();
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.sabores.index', compact('sabores', 'categorias'));
    }

    public function create(): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.sabores.create', compact('categorias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorias,id'],
        ]);

        // Un mismo sabor puede repetirse en distintas categorías (ej: "Fresa" en
        // Yogures y en Kombuchas), pero no dos veces dentro de la misma categoría.
        $existe = Sabor::where('nombre', $data['nombre'])
            ->where('categoria_id', $data['categoria_id'])
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors(['nombre' => 'Ese sabor ya existe en esta categoría.']);
        }

        Sabor::create($data);

        return redirect()
            ->route('admin.sabores.index')
            ->with('success', 'Sabor creado correctamente.');
    }

    public function edit(Sabor $sabor): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.sabores.edit', compact('sabor', 'categorias'));
    }

    public function update(Request $request, Sabor $sabor): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorias,id'],
        ]);

        $existe = Sabor::where('nombre', $data['nombre'])
            ->where('categoria_id', $data['categoria_id'])
            ->where('id', '!=', $sabor->id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->withErrors(['nombre' => 'Ese sabor ya existe en esta categoría.']);
        }

        $sabor->update($data);

        return redirect()
            ->route('admin.sabores.index')
            ->with('success', 'Sabor actualizado correctamente.');
    }

    public function destroy(Sabor $sabor): RedirectResponse
    {
        if ($sabor->productos()->exists()) {
            return redirect()
                ->route('admin.sabores.index')
                ->with('error', 'No se puede eliminar: hay productos usando este sabor.');
        }

        $sabor->delete();

        return redirect()
            ->route('admin.sabores.index')
            ->with('success', 'Sabor eliminado correctamente.');
    }
}
