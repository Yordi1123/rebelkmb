<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsumoRequest;
use App\Models\CategoriaInsumo;
use App\Models\Insumo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class InsumoController extends Controller
{
    public function index(): View
    {
        $with = ['categoriaInsumo'];
        if (class_exists(\App\Models\Proveedor::class)) {
            $with[] = 'proveedor';
        }

        $insumos = Insumo::with($with)
            ->when(request('buscar'), function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('codigo', 'like', "%{$buscar}%");
            })
            ->when(request('categoria_insumo_id'), function ($query, $categoriaId) {
                $query->where('categoria_insumo_id', $categoriaId);
            })
            ->when(request('stock_bajo'), function ($query) {
                $query->whereColumn('stock_actual', '<=', 'stock_minimo');
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        $categorias = CategoriaInsumo::orderBy('nombre')->get();

        return view('admin.insumos.index', compact('insumos', 'categorias'));
    }

    public function create(): View
    {
        $categorias = CategoriaInsumo::orderBy('nombre')->get();
        $proveedores = $this->proveedoresDisponibles();

        return view('admin.insumos.create', compact('categorias', 'proveedores'));
    }

    public function store(InsumoRequest $request): RedirectResponse
    {
        Insumo::create([
            ...$request->validated(),
            'activo' => $request->boolean('activo'),
        ]);

        return redirect()
            ->route('admin.insumos.index')
            ->with('success', 'Insumo creado correctamente.');
    }

    public function edit(Insumo $insumo): View
    {
        $categorias = CategoriaInsumo::orderBy('nombre')->get();
        $proveedores = $this->proveedoresDisponibles();

        return view('admin.insumos.edit', compact('insumo', 'categorias', 'proveedores'));
    }

    public function update(InsumoRequest $request, Insumo $insumo): RedirectResponse
    {
        $data = $request->validated();
        unset($data['stock_actual']); // Protegemos el stock en la actualización (solo Kardex puede cambiarlo)

        $insumo->update([
            ...$data,
            'activo' => $request->boolean('activo'),
        ]);

        return redirect()
            ->route('admin.insumos.index')
            ->with('success', 'Insumo actualizado correctamente.');
    }

    public function destroy(Insumo $insumo): RedirectResponse
    {
        $insumo->update(['activo' => ! $insumo->activo]);

        $estado = $insumo->activo ? 'activado' : 'desactivado';

        return redirect()
            ->route('admin.insumos.index')
            ->with('success', "Insumo {$estado} correctamente.");
    }

    /**
     * Carga los proveedores de forma segura: si el modelo Proveedor de
     * Franco aún no existe en esta rama (su módulo no se ha fusionado),
     * simplemente devuelve una lista vacía en vez de romper la página.
     */
    private function proveedoresDisponibles(): Collection
    {
        if (! class_exists(\App\Models\Proveedor::class)) {
            return collect();
        }

        return \App\Models\Proveedor::orderBy('id')->get();
    }
}
