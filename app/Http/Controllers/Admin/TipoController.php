<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Tipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class TipoController extends Controller
{
    public function index(): View
    {
        $tipos = Tipo::with('categoria')->orderBy('nombre')->get();

        return view('admin.tipos.index', compact('tipos'));
    }

    public function create(): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.tipos.create', compact('categorias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:10', 'unique:tipos,codigo'],
            'nombre' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorias,id'],
        ]);

        Tipo::create($data);

        return redirect()
            ->route('admin.tipos.index')
            ->with('success', 'Tipo creado correctamente.');
    }

    public function edit(Tipo $tipo): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.tipos.edit', compact('tipo', 'categorias'));
    }

    public function update(Request $request, Tipo $tipo): RedirectResponse
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:10', Rule::unique('tipos', 'codigo')->ignore($tipo->id)],
            'nombre' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorias,id'],
        ]);

        $tipo->update($data);

        return redirect()
            ->route('admin.tipos.index')
            ->with('success', 'Tipo actualizado correctamente.');
    }

    public function destroy(Tipo $tipo): RedirectResponse
    {
        if ($tipo->productos()->exists()) {
            return redirect()
                ->route('admin.tipos.index')
                ->with('error', 'No se puede eliminar: hay productos usando este tipo.');
        }

        $tipo->delete();

        return redirect()
            ->route('admin.tipos.index')
            ->with('success', 'Tipo eliminado correctamente.');
    }
}
