@extends('layouts.admin')

@section('title', 'Productos')
@section('breadcrumb', 'Productos')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Productos</h1>
        </div>
        <a href="{{ route('admin.productos.create') }}" class="ap-btn ap-btn--primary">
            + Nuevo producto
        </a>
    </div>

    @if (session('success'))
        <div class="ap-panel" style="border-left: 4px solid #3aa76d; margin-bottom: 16px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="ap-panel" style="margin-bottom: 20px;">
        <form method="GET" action="{{ route('admin.productos.index') }}" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <input
                type="text"
                name="buscar"
                class="ap-search"
                placeholder="Buscar por nombre, código o sabor..."
                value="{{ request('buscar') }}"
            >

            <select name="categoria_id" class="ap-input" onchange="this.form.submit()">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(request('categoria_id') == $categoria->id)>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="ap-btn ap-btn--secondary">Buscar</button>
        </form>
    </div>

    <div class="ap-table-panel">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Sabor</th>
                    <th>Presentación</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto->tipo->codigo ?? '—' }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->categoria->nombre ?? '—' }}</td>
                        <td>{{ $producto->sabor->nombre ?? '—' }}</td>
                        <td>{{ $producto->presentacion ?? '—' }}</td>
                        <td>
                            @if ($producto->activo)
                                <span class="ap-badge ap-status--green">Activo</span>
                            @else
                                <span class="ap-badge ap-status--yellow">Inactivo</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('admin.productos.edit', $producto) }}" class="ap-icon-btn" style="color: #6257df;" title="Editar">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form
                                    method="POST"
                                    action="{{ route('admin.productos.destroy', $producto) }}"
                                    style="display: inline;"
                                    data-confirm="¿Eliminar este producto? Esta acción no se puede deshacer."
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ap-icon-btn" style="color: #d64545;" title="Eliminar">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 24px;">
                            No hay productos registrados todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        {{ $productos->links('vendor.pagination.ap-custom') }}
    </div>
@endsection
