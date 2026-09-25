@extends('layouts.admin')

@section('title', 'Insumos')
@section('breadcrumb', 'Insumos')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Materia Prima</p>
            <h1>Insumos</h1>
        </div>
        <a href="{{ route('admin.insumos.create') }}" class="ap-btn ap-btn--primary">
            + Nuevo insumo
        </a>
    </div>

    @if (session('success'))
        <div class="ap-panel" style="border-left: 4px solid #3aa76d; margin-bottom: 16px;">{{ session('success') }}</div>
    @endif

    <div class="ap-panel" style="margin-bottom: 20px;">
        <form method="GET" action="{{ route('admin.insumos.index') }}" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <input
                type="text"
                name="buscar"
                class="ap-search"
                placeholder="Buscar por nombre..."
                value="{{ request('buscar') }}"
            >

            <select name="categoria_insumo_id" class="ap-input" onchange="this.form.submit()">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(request('categoria_insumo_id') == $categoria->id)>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>

            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; cursor: pointer;">
                <input
                    type="checkbox"
                    name="stock_bajo"
                    value="1"
                    onchange="this.form.submit()"
                    @checked(request('stock_bajo'))
                >
                Solo stock bajo
            </label>

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
                    <th>Unidad</th>
                    <th>Stock actual</th>
                    <th>Stock mínimo</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($insumos as $insumo)
                    <tr>
                        <td>{{ $insumo->codigo }}</td>
                        <td>{{ $insumo->nombre }}</td>
                        <td>{{ $insumo->categoriaInsumo->nombre ?? '—' }}</td>
                        <td>{{ ucfirst($insumo->unidad_medida) }}</td>
                        <td>{{ number_format($insumo->stock_actual, 2) }}</td>
                        <td>{{ number_format($insumo->stock_minimo, 2) }}</td>
                        <td>
                            @if (! $insumo->activo)
                                <span class="ap-badge ap-status--yellow">Inactivo</span>
                            @elseif ($insumo->stock_actual <= 0)
                                <span class="ap-badge" style="background-color: #ffebe9; color: #cf222e; border: 1px solid #ff8182;">Stock Crítico</span>
                            @elseif ($insumo->stock_bajo)
                                <span class="ap-badge ap-status--red">⚠ Stock bajo</span>
                            @else
                                <span class="ap-badge ap-status--green">OK</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('admin.insumos.edit', $insumo) }}" class="ap-btn ap-btn--secondary">Editar</a>
                            <form
                                method="POST"
                                action="{{ route('admin.insumos.destroy', $insumo) }}"
                                style="display: inline;"
                                data-confirm="¿{{ $insumo->activo ? 'Desactivar' : 'Activar' }} este insumo?"
                                data-confirm-label="{{ $insumo->activo ? 'Desactivar' : 'Activar' }}"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ap-btn ap-btn--secondary">
                                    {{ $insumo->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 24px;">No hay insumos registrados todavía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        {{ $insumos->links('vendor.pagination.ap-custom') }}
    </div>
@endsection
