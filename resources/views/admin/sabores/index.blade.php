@extends('layouts.admin')

@section('title', 'Sabores')
@section('breadcrumb', 'Productos / Sabores')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Sabores</h1>
        </div>
        <a href="{{ route('admin.sabores.create') }}" class="ap-btn ap-btn--primary">
            + Nuevo sabor
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
                    <th>Categoría</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sabores as $sabor)
                    <tr>
                        <td>{{ $sabor->nombre }}</td>
                        <td>{{ $sabor->categoria->nombre ?? '—' }}</td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('admin.sabores.edit', $sabor) }}" class="ap-btn ap-btn--secondary">Editar</a>
                            <form
                                method="POST"
                                action="{{ route('admin.sabores.destroy', $sabor) }}"
                                style="display: inline;"
                                data-confirm="¿Eliminar este sabor? Esta acción no se puede deshacer."
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
                            No hay sabores registrados todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
