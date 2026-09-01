<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Sabor;
use App\Http\Requests\SaborRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function store(SaborRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Sabor::create($data);

        $mensaje = 'Sabor creado correctamente.';

        if ($request->boolean('_redirect_back')) {
            return back()->with('success', $mensaje);
        }

        return redirect()
            ->route('admin.sabores.index')
            ->with('success', $mensaje);
    }

    public function edit(Sabor $sabor): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.sabores.edit', compact('sabor', 'categorias'));
    }

    public function update(SaborRequest $request, Sabor $sabor): RedirectResponse
    {
        $data = $request->validated();

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
