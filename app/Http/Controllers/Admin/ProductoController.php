<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function index(): View
    {
        $productos = Producto::with('categoria')
            ->when(request('buscar'), function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('codigo', 'like', "%{$buscar}%");
            })
            ->when(request('categoria_id'), function ($query, $categoriaId) {
                $query->where('categoria_id', $categoriaId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    public function create(): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.create', compact('categorias'));
    }

    public function store(ProductoRequest $request): RedirectResponse
    {
        Producto::create([
            ...$request->validated(),
            'activo' => $request->boolean('activo'),
        ]);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(ProductoRequest $request, Producto $producto): RedirectResponse
    {
        $producto->update([
            ...$request->validated(),
            'activo' => $request->boolean('activo'),
        ]);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
