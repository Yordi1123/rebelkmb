@extends('layouts.admin')

@section('title', 'Categorías')
@section('breadcrumb', 'Productos / Categorías')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Categorías</h1>
        </div>
        <button type="button" class="ap-btn ap-btn--primary" onclick="openModal('modal-categoria-crear')">
            + Nueva categoría
        </button>
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
                            <button
                                type="button"
                                class="ap-btn ap-btn--secondary"
                                data-edit-categoria
                                data-id="{{ $categoria->id }}"
                                data-nombre="{{ $categoria->nombre }}"
                                data-descripcion="{{ $categoria->descripcion ?? '' }}"
                                data-url="{{ route('admin.categorias.update', $categoria) }}"
                            >
                                Editar
                            </button>
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

    {{-- ── MODAL: CREAR CATEGORÍA ─────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-categoria-crear">
        <div class="ap-modal">
            <h3>Nueva categoría</h3>
            <form method="POST" action="{{ route('admin.categorias.store') }}">
                @csrf
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="crear-nombre">Nombre</label>
                        <input
                            type="text"
                            id="crear-nombre"
                            name="nombre"
                            class="ap-input @error('nombre') ap-input--error @enderror"
                            value="{{ old('nombre') }}"
                            placeholder="Ej: Yogures, Kombuchas"
                            autocomplete="off"
                        >
                        @error('nombre')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group" style="grid-column: 1 / -1;">
                        <label for="crear-descripcion">Descripción (opcional)</label>
                        <input
                            type="text"
                            id="crear-descripcion"
                            name="descripcion"
                            class="ap-input @error('descripcion') ap-input--error @enderror"
                            value="{{ old('descripcion') }}"
                            autocomplete="off"
                        >
                        @error('descripcion')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-categoria-crear')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Crear categoría</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── MODAL: EDITAR CATEGORÍA ─────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-categoria-editar">
        <div class="ap-modal">
            <h3>Editar categoría</h3>
            <form method="POST" id="form-editar-categoria" action="">
                @csrf
                @method('PUT')
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="editar-nombre">Nombre</label>
                        <input
                            type="text"
                            id="editar-nombre"
                            name="nombre"
                            class="ap-input"
                            autocomplete="off"
                        >
                    </div>
                    <div class="ap-form-group" style="grid-column: 1 / -1;">
                        <label for="editar-descripcion">Descripción (opcional)</label>
                        <input
                            type="text"
                            id="editar-descripcion"
                            name="descripcion"
                            class="ap-input"
                            autocomplete="off"
                        >
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-categoria-editar')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Pre-popular modal de edición al hacer clic en "Editar"
    document.querySelectorAll('[data-edit-categoria]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editar-nombre').value       = btn.dataset.nombre;
            document.getElementById('editar-descripcion').value  = btn.dataset.descripcion;
            document.getElementById('form-editar-categoria').action = btn.dataset.url;
            openModal('modal-categoria-editar');
        });
    });

    // Si hay errores de validación, re-abrir el modal de creación automáticamente
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('modal-categoria-crear'));
    @endif
</script>
@endpush
