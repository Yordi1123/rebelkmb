@extends('layouts.admin')

@section('title', 'Categorías')
@section('breadcrumb', 'Productos / Categorías')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Categorías</h1>
        </div>
        <a href="{{ route('admin.categorias.create') }}" class="ap-btn ap-btn--primary">
            + Nueva categoría
        </a>
    </div>

    @if (session('success'))
        <div class="ap-panel" style="border-left: 4px solid #3aa76d; margin-bottom: 16px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="ap-panel" style="border-left: 4px solid #d64545; margin-bottom: 16px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="ap-table-panel">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nombre }}</td>
                        <td>{{ $categoria->descripcion ?? '—' }}</td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('admin.categorias.edit', $categoria) }}" class="ap-btn ap-btn--secondary">Editar</a>
                            <form
                                method="POST"
                                action="{{ route('admin.categorias.destroy', $categoria) }}"
                                style="display: inline;"
                                data-confirm="¿Eliminar esta categoría? Esta acción no se puede deshacer."
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ap-btn ap-btn--secondary">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 24px;">
                            No hay categorías registradas todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
