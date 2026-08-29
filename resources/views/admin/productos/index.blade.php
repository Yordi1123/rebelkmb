@extends('layouts.admin')

@section('title', 'Productos')
@section('breadcrumb', 'Productos')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Inventario</p>
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
                placeholder="Buscar por nombre o código..."
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
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->categoria->nombre ?? '—' }}</td>
                        <td>{{ $producto->sabor ?? '—' }}</td>
                        <td>{{ $producto->presentacion ?? '—' }}</td>
                        <td>
                            @if ($producto->activo)
                                <span class="ap-badge ap-status--green">Activo</span>
                            @else
                                <span class="ap-badge ap-status--yellow">Inactivo</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('admin.productos.edit', $producto) }}" class="ap-btn ap-btn--secondary">
                                Editar
                            </a>
                            <form
                                method="POST"
                                action="{{ route('admin.productos.destroy', $producto) }}"
                                style="display: inline;"
                                data-confirm="¿Eliminar este producto? Esta acción no se puede deshacer."
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ap-btn ap-btn--secondary">Eliminar</button>
                            </form>
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
