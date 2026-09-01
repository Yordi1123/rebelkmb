@extends('layouts.admin')

@section('title', 'Sabores')
@section('breadcrumb', 'Productos / Sabores')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Sabores</h1>
        </div>
        <button type="button" class="ap-btn ap-btn--primary" onclick="openModal('modal-sabor-crear')">
            + Nuevo sabor
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
                            <button
                                type="button"
                                class="ap-btn ap-btn--secondary"
                                data-edit-sabor
                                data-id="{{ $sabor->id }}"
                                data-nombre="{{ $sabor->nombre }}"
                                data-categoria-id="{{ $sabor->categoria_id }}"
                                data-url="{{ route('admin.sabores.update', $sabor) }}"
                            >
                                Editar
                            </button>
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

    {{-- ── MODAL: CREAR SABOR ──────────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-sabor-crear">
        <div class="ap-modal">
            <h3>Nuevo sabor</h3>
            <form method="POST" action="{{ route('admin.sabores.store') }}">
                @csrf
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="crear-nombre-sabor">Nombre</label>
                        <input
                            type="text"
                            id="crear-nombre-sabor"
                            name="nombre"
                            class="ap-input @error('nombre') ap-input--error @enderror"
                            value="{{ old('nombre') }}"
                            placeholder="Ej: Fresa, Maracuyá"
                            autocomplete="off"
                        >
                        @error('nombre')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group" style="grid-column: 1 / -1;">
                        <label for="crear-categoria-sabor">Categoría</label>
                        <select
                            id="crear-categoria-sabor"
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
                        <small style="color: #6b6355; font-size: 0.78rem;">
                            Un mismo sabor (ej: "Fresa") puede existir en varias categorías por separado.
                        </small>
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-sabor-crear')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Crear sabor</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── MODAL: EDITAR SABOR ─────────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-sabor-editar">
        <div class="ap-modal">
            <h3>Editar sabor</h3>
            <form method="POST" id="form-editar-sabor" action="">
                @csrf
                @method('PUT')
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="editar-nombre-sabor">Nombre</label>
                        <input
                            type="text"
                            id="editar-nombre-sabor"
                            name="nombre"
                            class="ap-input"
                            autocomplete="off"
                        >
                    </div>
                    <div class="ap-form-group" style="grid-column: 1 / -1;">
                        <label for="editar-categoria-sabor">Categoría</label>
                        <select id="editar-categoria-sabor" name="categoria_id" class="ap-input">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        <small style="color: #6b6355; font-size: 0.78rem;">
                            Un mismo sabor (ej: "Fresa") puede existir en varias categorías por separado.
                        </small>
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-sabor-editar')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Pre-popular modal de edición
    document.querySelectorAll('[data-edit-sabor]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editar-nombre-sabor').value  = btn.dataset.nombre;
            document.getElementById('form-editar-sabor').action   = btn.dataset.url;

            // Seleccionar la categoría correcta
            const sel = document.getElementById('editar-categoria-sabor');
            [...sel.options].forEach(opt => {
                opt.selected = (opt.value === btn.dataset.categoriaId);
            });

            openModal('modal-sabor-editar');
        });
    });

    // Re-abrir modal crear si hay errores de validación
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('modal-sabor-crear'));
    @endif
</script>
@endpush
