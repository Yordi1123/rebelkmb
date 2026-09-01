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
                    <th>Sabor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tipos as $tipo)
                    <tr>
                        <td>{{ $tipo->codigo }}</td>
                        <td>{{ $tipo->nombre }}</td>
                        <td>{{ $tipo->categoria->nombre ?? '—' }}</td>
                        <td>
                            @if ($tipo->requiere_sabor)
                                <span style="
                                    display: inline-block;
                                    padding: 2px 10px;
                                    border-radius: 20px;
                                    font-size: 0.75rem;
                                    font-weight: 600;
                                    background: rgba(98,87,223,0.10);
                                    color: #6257df;
                                ">Con sabor</span>
                            @else
                                <span style="
                                    display: inline-block;
                                    padding: 2px 10px;
                                    border-radius: 20px;
                                    font-size: 0.75rem;
                                    font-weight: 600;
                                    background: rgba(107,99,85,0.10);
                                    color: #6b6355;
                                ">Sin sabor</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                <button
                                    type="button"
                                    class="ap-icon-btn" style="color: #6257df;"
                                    data-edit-tipo
                                    data-id="{{ $tipo->id }}"
                                    data-codigo="{{ $tipo->codigo }}"
                                    data-nombre="{{ $tipo->nombre }}"
                                    data-categoria-id="{{ $tipo->categoria_id }}"
                                    data-requiere-sabor="{{ $tipo->requiere_sabor ? '1' : '0' }}"
                                    data-url="{{ route('admin.tipos.update', $tipo) }}"
                                    title="Editar"
                                >
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form
                                    method="POST"
                                    action="{{ route('admin.tipos.destroy', $tipo) }}"
                                    style="display: inline;"
                                    data-confirm="¿Eliminar este tipo? Esta acción no se puede deshacer."
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
                        <td colspan="5" style="text-align: center; padding: 24px;">
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
                    <div class="ap-form-group ap-form-group--checkbox" style="grid-column: 1 / -1;">
                        <label>
                            <input
                                type="checkbox"
                                name="requiere_sabor"
                                value="1"
                                @checked(old('requiere_sabor'))
                            >
                            Requiere sabor
                            <small style="display:block; color:#6b6355; font-size:0.78rem; margin-top:2px; font-weight:400;">
                                Ej: Yogurt Frutado ✓ — Yogurt Natural ✗
                            </small>
                        </label>
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
                    <div class="ap-form-group ap-form-group--checkbox" style="grid-column: 1 / -1;">
                        <label>
                            <input
                                type="checkbox"
                                id="editar-requiere-sabor"
                                name="requiere_sabor"
                                value="1"
                            >
                            Requiere sabor
                            <small style="display:block; color:#6b6355; font-size:0.78rem; margin-top:2px; font-weight:400;">
                                Ej: Yogurt Frutado ✓ — Yogurt Natural ✗
                            </small>
                        </label>
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
            document.getElementById('editar-codigo').value      = btn.dataset.codigo;
            document.getElementById('editar-nombre-tipo').value = btn.dataset.nombre;
            document.getElementById('form-editar-tipo').action  = btn.dataset.url;
            document.getElementById('editar-requiere-sabor').checked = btn.dataset.requiereSabor === '1';

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
