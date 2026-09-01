@extends('layouts.admin')

@section('title', 'Tipos')
@section('breadcrumb', 'Productos / Tipos')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Tipos de producto</h1>
        </div>
        <button type="button" class="ap-btn ap-btn--primary" onclick="openModal('modal-tipo-crear')">
            + Nuevo tipo
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
                            <button
                                type="button"
                                class="ap-btn ap-btn--secondary"
                                data-edit-tipo
                                data-id="{{ $tipo->id }}"
                                data-codigo="{{ $tipo->codigo }}"
                                data-nombre="{{ $tipo->nombre }}"
                                data-categoria-id="{{ $tipo->categoria_id }}"
                                data-url="{{ route('admin.tipos.update', $tipo) }}"
                            >
                                Editar
                            </button>
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

    {{-- ── MODAL: CREAR TIPO ───────────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-tipo-crear">
        <div class="ap-modal">
            <h3>Nuevo tipo</h3>
            <form method="POST" action="{{ route('admin.tipos.store') }}">
                @csrf
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="crear-codigo">Código</label>
                        <input
                            type="text"
                            id="crear-codigo"
                            name="codigo"
                            class="ap-input @error('codigo') ap-input--error @enderror"
                            value="{{ old('codigo') }}"
                            placeholder="Ej: YN, YF, KB"
                            style="text-transform: uppercase;"
                            autocomplete="off"
                        >
                        @error('codigo')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group">
                        <label for="crear-nombre-tipo">Nombre</label>
                        <input
                            type="text"
                            id="crear-nombre-tipo"
                            name="nombre"
                            class="ap-input @error('nombre') ap-input--error @enderror"
                            value="{{ old('nombre') }}"
                            placeholder="Ej: Yogurt Natural"
                            autocomplete="off"
                        >
                        @error('nombre')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group" style="grid-column: 1 / -1;">
                        <label for="crear-categoria-tipo">Categoría</label>
                        <select
                            id="crear-categoria-tipo"
                            name="categoria_id"
                            class="ap-input @error('categoria_id') ap-input--error @enderror"
                        >
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-tipo-crear')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Crear tipo</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── MODAL: EDITAR TIPO ──────────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-tipo-editar">
        <div class="ap-modal">
            <h3>Editar tipo</h3>
            <form method="POST" id="form-editar-tipo" action="">
                @csrf
                @method('PUT')
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="editar-codigo">Código</label>
                        <input
                            type="text"
                            id="editar-codigo"
                            name="codigo"
                            class="ap-input"
                            style="text-transform: uppercase;"
                            autocomplete="off"
                        >
                    </div>
                    <div class="ap-form-group">
                        <label for="editar-nombre-tipo">Nombre</label>
                        <input
                            type="text"
                            id="editar-nombre-tipo"
                            name="nombre"
                            class="ap-input"
                            autocomplete="off"
                        >
                    </div>
                    <div class="ap-form-group" style="grid-column: 1 / -1;">
                        <label for="editar-categoria-tipo">Categoría</label>
                        <select id="editar-categoria-tipo" name="categoria_id" class="ap-input">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-tipo-editar')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Pre-popular modal de edición
    document.querySelectorAll('[data-edit-tipo]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editar-codigo').value          = btn.dataset.codigo;
            document.getElementById('editar-nombre-tipo').value     = btn.dataset.nombre;
            document.getElementById('form-editar-tipo').action      = btn.dataset.url;

            // Seleccionar la categoría correcta
            const sel = document.getElementById('editar-categoria-tipo');
            [...sel.options].forEach(opt => {
                opt.selected = (opt.value === btn.dataset.categoriaId);
            });

            openModal('modal-tipo-editar');
        });
    });

    // Re-abrir modal crear si hay errores de validación
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('modal-tipo-crear'));
    @endif
</script>
@endpush
