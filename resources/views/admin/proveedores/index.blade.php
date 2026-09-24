@extends('layouts.admin')

@section('title', 'Proveedores')
@section('breadcrumb', 'Operaciones / Proveedores')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Operaciones</p>
            <h1>Proveedores</h1>
        </div>
        <button type="button" class="ap-btn ap-btn--primary" onclick="openModal('modal-proveedor-crear')">
            + Nuevo proveedor
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
                    <th>Razón Social</th>
                    <th>RUC</th>
                    <th>Dirección</th>
                    <th>Contacto</th>
                    <th>Celular</th>
                    <th>Lead Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->nombre }}</td>
                        <td style="font-weight: 400;">{{ $proveedor->ruc ?? '—' }}</td>
                        <td style="font-weight: 400; max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $proveedor->direccion }}">
                            {{ $proveedor->direccion ?? '—' }}
                        </td>
                        <td style="font-weight: 400;">{{ $proveedor->contacto_nombre ?? '—' }}</td>
                        <td style="font-weight: 400;">{{ $proveedor->contacto_celular ?? '—' }}</td>
                        <td>
                            <span class="ap-status" style="background: #e9f2ff; color: #4382df;">
                                {{ $proveedor->lead_time_dias }} {{ $proveedor->lead_time_dias === 1 ? 'día' : 'días' }}
                            </span>
                        </td>
                        <td style="white-space: nowrap;">
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                {{-- Botón Editar --}}
                                <button
                                    type="button"
                                    class="ap-icon-btn" style="color: #6257df;"
                                    data-edit-proveedor
                                    data-id="{{ $proveedor->id }}"
                                    data-nombre="{{ $proveedor->nombre }}"
                                    data-ruc="{{ $proveedor->ruc }}"
                                    data-direccion="{{ $proveedor->direccion }}"
                                    data-contacto-nombre="{{ $proveedor->contacto_nombre }}"
                                    data-contacto-celular="{{ $proveedor->contacto_celular }}"
                                    data-lead-time="{{ $proveedor->lead_time_dias }}"
                                    data-url="{{ route('admin.proveedores.update', $proveedor) }}"
                                    title="Editar"
                                >
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                {{-- Botón Eliminar --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.proveedores.destroy', $proveedor) }}"
                                    style="display: inline;"
                                    data-confirm="¿Eliminar al proveedor {{ $proveedor->nombre }}? Esta acción no se puede deshacer."
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
                        <td colspan="7" style="text-align: center; padding: 24px;">
                            No hay proveedores registrados todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginación --}}
        @if ($proveedores->hasPages())
            <div style="padding: 16px; display: flex; justify-content: center;">
                {{ $proveedores->links('vendor.pagination.ap-custom') }}
            </div>
        @endif
    </div>

    {{-- ── MODAL: CREAR PROVEEDOR ─────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-proveedor-crear">
        <div class="ap-modal">
            <h3>Nuevo proveedor</h3>
            <form method="POST" action="{{ route('admin.proveedores.store') }}">
                @csrf
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="crear-nombre">Razón Social</label>
                        <input
                            type="text"
                            id="crear-nombre"
                            name="nombre"
                            class="ap-input @error('nombre') ap-input--error @enderror"
                            value="{{ old('nombre') }}"
                            placeholder="Ej: Distribuidora Lima SAC"
                            autocomplete="off"
                        >
                        @error('nombre')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group">
                        <label for="crear-ruc">RUC</label>
                        <input
                            type="text"
                            id="crear-ruc"
                            name="ruc"
                            class="ap-input @error('ruc') ap-input--error @enderror"
                            value="{{ old('ruc') }}"
                            placeholder="Ej: 20512345678"
                            autocomplete="off"
                            inputmode="numeric"
                            maxlength="11"
                            pattern="[0-9]{11}"
                            title="El RUC debe tener exactamente 11 dígitos numéricos"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                        @error('ruc')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group" style="grid-column: 1 / -1;">
                        <label for="crear-direccion">Dirección</label>
                        <input
                            type="text"
                            id="crear-direccion"
                            name="direccion"
                            class="ap-input @error('direccion') ap-input--error @enderror"
                            value="{{ old('direccion') }}"
                            placeholder="Ej: Av. Industrial 1234, Ate"
                            autocomplete="off"
                        >
                        @error('direccion')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group">
                        <label for="crear-contacto-nombre">Nombre del contacto</label>
                        <input
                            type="text"
                            id="crear-contacto-nombre"
                            name="contacto_nombre"
                            class="ap-input @error('contacto_nombre') ap-input--error @enderror"
                            value="{{ old('contacto_nombre') }}"
                            placeholder="Ej: Juan Pérez"
                            autocomplete="off"
                        >
                        @error('contacto_nombre')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group">
                        <label for="crear-contacto-celular">Celular</label>
                        <input
                            type="text"
                            id="crear-contacto-celular"
                            name="contacto_celular"
                            class="ap-input @error('contacto_celular') ap-input--error @enderror"
                            value="{{ old('contacto_celular') }}"
                            placeholder="Ej: 987654321"
                            autocomplete="off"
                            inputmode="numeric"
                            maxlength="9"
                            pattern="[0-9]{9}"
                            title="El celular debe tener exactamente 9 dígitos numéricos"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                        @error('contacto_celular')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group">
                        <label for="crear-lead-time">Lead Time (días)</label>
                        <input
                            type="number"
                            id="crear-lead-time"
                            name="lead_time_dias"
                            class="ap-input @error('lead_time_dias') ap-input--error @enderror"
                            value="{{ old('lead_time_dias', 0) }}"
                            min="0"
                            placeholder="Ej: 3"
                        >
                        @error('lead_time_dias')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-proveedor-crear')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Crear proveedor</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── MODAL: EDITAR PROVEEDOR ─────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-proveedor-editar">
        <div class="ap-modal">
            <h3>Editar proveedor</h3>
            <form method="POST" id="form-editar-proveedor" action="">
                @csrf
                @method('PUT')
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="editar-nombre">Razón Social</label>
                        <input
                            type="text"
                            id="editar-nombre"
                            name="nombre"
                            class="ap-input"
                            autocomplete="off"
                        >
                    </div>
                    <div class="ap-form-group">
                        <label for="editar-ruc">RUC</label>
                        <input
                            type="text"
                            id="editar-ruc"
                            name="ruc"
                            class="ap-input"
                            autocomplete="off"
                            inputmode="numeric"
                            maxlength="11"
                            pattern="[0-9]{11}"
                            title="El RUC debe tener exactamente 11 dígitos numéricos"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                    </div>
                    <div class="ap-form-group" style="grid-column: 1 / -1;">
                        <label for="editar-direccion">Dirección</label>
                        <input
                            type="text"
                            id="editar-direccion"
                            name="direccion"
                            class="ap-input"
                            autocomplete="off"
                        >
                    </div>
                    <div class="ap-form-group">
                        <label for="editar-contacto-nombre">Nombre del contacto</label>
                        <input
                            type="text"
                            id="editar-contacto-nombre"
                            name="contacto_nombre"
                            class="ap-input"
                            autocomplete="off"
                        >
                    </div>
                    <div class="ap-form-group">
                        <label for="editar-contacto-celular">Celular</label>
                        <input
                            type="text"
                            id="editar-contacto-celular"
                            name="contacto_celular"
                            class="ap-input"
                            autocomplete="off"
                            inputmode="numeric"
                            maxlength="9"
                            pattern="[0-9]{9}"
                            title="El celular debe tener exactamente 9 dígitos numéricos"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                    </div>
                    <div class="ap-form-group">
                        <label for="editar-lead-time">Lead Time (días)</label>
                        <input
                            type="number"
                            id="editar-lead-time"
                            name="lead_time_dias"
                            class="ap-input"
                            min="0"
                        >
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-proveedor-editar')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Pre-popular modal de edición al hacer clic en "Editar"
    document.querySelectorAll('[data-edit-proveedor]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editar-nombre').value           = btn.dataset.nombre;
            document.getElementById('editar-ruc').value              = btn.dataset.ruc || '';
            document.getElementById('editar-direccion').value        = btn.dataset.direccion || '';
            document.getElementById('editar-contacto-nombre').value  = btn.dataset.contactoNombre || '';
            document.getElementById('editar-contacto-celular').value = btn.dataset.contactoCelular || '';
            document.getElementById('editar-lead-time').value        = btn.dataset.leadTime;
            document.getElementById('form-editar-proveedor').action  = btn.dataset.url;
            openModal('modal-proveedor-editar');
        });
    });

    // Si hay errores de validación, re-abrir el modal de creación automáticamente
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('modal-proveedor-crear'));
    @endif
</script>
@endpush
