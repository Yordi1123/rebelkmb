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
                    <th>Unidad de medida</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nombre }}</td>
                        <td>{{ $categoria->descripcion ?? '—' }}</td>
                        <td>{{ $categoria->unidad_medida }}</td>
                        <td style="white-space: nowrap;">
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                <button
                                    type="button"
                                    class="ap-icon-btn" style="color: #6257df;"
                                    data-edit-categoria
                                    data-id="{{ $categoria->id }}"
                                    data-nombre="{{ $categoria->nombre }}"
                                    data-descripcion="{{ $categoria->descripcion ?? '' }}"
                                    data-unidad="{{ $categoria->unidad_medida }}"
                                    data-url="{{ route('admin.categorias.update', $categoria) }}"
                                    title="Editar"
                                >
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form
                                    method="POST"
                                    action="{{ route('admin.categorias.destroy', $categoria) }}"
                                    style="display: inline;"
                                    data-confirm="¿Eliminar esta categoría? Esta acción no se puede deshacer."
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
                    <div class="ap-form-group">
                        <label for="crear-unidad">Unidad de medida base</label>
                        <select id="crear-unidad" name="unidad_medida" class="ap-input @error('unidad_medida') ap-input--error @enderror">
                            <option value="">Selecciona una unidad</option>
                            @foreach (\App\Models\Categoria::UNIDADES_MEDIDA as $unidad)
                                <option value="{{ $unidad }}" @selected(old('unidad_medida') === $unidad)>
                                    {{ $unidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('unidad_medida')
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
                    <div class="ap-form-group">
                        <label for="editar-unidad">Unidad de medida base</label>
                        <select id="editar-unidad" name="unidad_medida" class="ap-input">
                            @foreach (\App\Models\Categoria::UNIDADES_MEDIDA as $unidad)
                                <option value="{{ $unidad }}">
                                    {{ $unidad }}
                                </option>
                            @endforeach
                        </select>
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
            document.getElementById('editar-unidad').value       = btn.dataset.unidad;
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
