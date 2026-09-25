<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProveedorController extends Controller
{
    public function index(): View
    {
        $proveedores = Proveedor::orderBy('nombre')->paginate(15);

        return view('admin.proveedores.index', compact('proveedores'));
    }

    public function create(): View
    {
        return view('admin.proveedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'           => ['required', 'string', 'max:255'],
            'ruc'              => ['nullable', 'digits:11', 'unique:proveedores,ruc'],
            'direccion'        => ['nullable', 'string', 'max:500'],
            'contacto_nombre'  => ['nullable', 'string', 'max:255'],
            'contacto_celular' => ['nullable', 'digits:9'],
            'lead_time_dias'   => ['required', 'integer', 'min:0'],
        ]);

        $proveedor = Proveedor::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $proveedor
            ]);
        }

        return redirect()
            ->route('admin.proveedores.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function edit(Proveedor $proveedore): View
    {
        return view('admin.proveedores.edit', ['proveedor' => $proveedore]);
    }

    public function update(Request $request, Proveedor $proveedore): RedirectResponse
    {
        $data = $request->validate([
            'nombre'           => ['required', 'string', 'max:255'],
            'ruc'              => ['nullable', 'digits:11', Rule::unique('proveedores', 'ruc')->ignore($proveedore->id)],
            'direccion'        => ['nullable', 'string', 'max:500'],
            'contacto_nombre'  => ['nullable', 'string', 'max:255'],
            'contacto_celular' => ['nullable', 'digits:9'],
            'lead_time_dias'   => ['required', 'integer', 'min:0'],
        ]);

        $proveedore->update($data);

        return redirect()
            ->route('admin.proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedore): RedirectResponse
    {
        // Protección: no eliminar si tiene órdenes de compra vinculadas
        // if ($proveedore->ordenesCompra()->exists()) {
        //     return redirect()
        //         ->route('admin.proveedores.index')
        //         ->with('error', 'No se puede eliminar: hay órdenes de compra asociadas a este proveedor.');
        // }

        $proveedore->delete();

        return redirect()
            ->route('admin.proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
