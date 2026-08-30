@extends('layouts.admin')

@section('title', 'Tipos')
@section('breadcrumb', 'Productos / Tipos')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Tipos de producto</h1>
        </div>
        <a href="{{ route('admin.tipos.create') }}" class="ap-btn ap-btn--primary">
            + Nuevo tipo
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
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tipos as $tipo)
                    <tr>
                        <td>{{ $tipo->codigo }}</td>
                        <td>{{ $tipo->nombre }}</td>
                        <td>{{ $tipo->categoria->nombre ?? '—' }}</td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('admin.tipos.edit', $tipo) }}" class="ap-btn ap-btn--secondary">Editar</a>
                            <form
                                method="POST"
                                action="{{ route('admin.tipos.destroy', $tipo) }}"
                                style="display: inline;"
                                data-confirm="¿Eliminar este tipo? Esta acción no se puede deshacer."
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ap-btn ap-btn--secondary">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 24px;">
                            No hay tipos registrados todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
