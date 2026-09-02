@extends('layouts.admin')

@section('title', 'Usuarios')
@section('breadcrumb', 'Gestión / Usuarios')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Gestión</p>
            <h1>Usuarios</h1>
        </div>
        <button type="button" class="ap-btn ap-btn--primary" onclick="openModal('modal-usuario-crear')">
            + Nuevo usuario
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
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->name }}</td>
                        <td style="font-weight: 400;">{{ $usuario->email }}</td>
                        <td>
                            @php
                                $rolColors = [
                                    'administrador' => 'background: #efedff; color: #6559df;',
                                    'planificador'  => 'background: #e9f2ff; color: #4382df;',
                                    'operador'      => 'background: #fff1df; color: #c78a35;',
                                    'calidad'       => 'background: #e6f8f0; color: #2aa873;',
                                ];
                            @endphp
                            <span class="ap-status" style="{{ $rolColors[$usuario->rol] ?? '' }}">
                                {{ ucfirst($usuario->rol) }}
                            </span>
                        </td>
                        <td>
                            @if ($usuario->activo)
                                <span class="ap-status ap-status--green">Activo</span>
                            @else
                                <span class="ap-status" style="background: #fff0f0; color: #dc6068;">Inactivo</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                {{-- Botón Editar --}}
                                <button
                                    type="button"
                                    class="ap-icon-btn" style="color: #6257df;"
                                    data-edit-usuario
                                    data-id="{{ $usuario->id }}"
                                    data-name="{{ $usuario->name }}"
                                    data-email="{{ $usuario->email }}"
                                    data-rol="{{ $usuario->rol }}"
                                    data-activo="{{ $usuario->activo ? '1' : '0' }}"
                                    data-url="{{ route('admin.usuarios.update', $usuario) }}"
                                    title="Editar"
                                >
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                {{-- Botón Activar/Desactivar --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.usuarios.destroy', $usuario) }}"
                                    style="display: inline;"
                                    data-confirm="{{ $usuario->activo ? '¿Desactivar a ' . $usuario->name . '? No podrá iniciar sesión.' : '¿Reactivar a ' . $usuario->name . '?' }}"
                                >
                                    @csrf
                                    @method('DELETE')
                                    @if ($usuario->activo)
                                        <button type="submit" class="ap-icon-btn" style="color: #d64545;" title="Desactivar">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </button>
                                    @else
                                        <button type="submit" class="ap-icon-btn" style="color: #2aa873;" title="Reactivar">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 24px;">
                            No hay usuarios registrados todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginación --}}
        @if ($usuarios->hasPages())
            <div style="padding: 16px; display: flex; justify-content: center;">
                {{ $usuarios->links('vendor.pagination.ap-custom') }}
            </div>
        @endif
    </div>

    {{-- ── MODAL: CREAR USUARIO ─────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-usuario-crear">
        <div class="ap-modal">
            <h3>Nuevo usuario</h3>
            <form method="POST" action="{{ route('admin.usuarios.store') }}">
                @csrf
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="crear-name">Nombre completo</label>
                        <input
                            type="text"
                            id="crear-name"
                            name="name"
                            class="ap-input @error('name') ap-input--error @enderror"
                            value="{{ old('name') }}"
                            placeholder="Ej: Juan Pérez"
                            autocomplete="off"
                        >
                        @error('name')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group">
                        <label for="crear-email">Correo electrónico</label>
                        <input
                            type="email"
                            id="crear-email"
                            name="email"
                            class="ap-input @error('email') ap-input--error @enderror"
                            value="{{ old('email') }}"
                            placeholder="Ej: usuario@rebelkmb.com"
                            autocomplete="off"
                        >
                        @error('email')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group">
                        <label for="crear-password">Contraseña</label>
                        <input
                            type="password"
                            id="crear-password"
                            name="password"
                            class="ap-input @error('password') ap-input--error @enderror"
                            placeholder="Mínimo 8 caracteres"
                            autocomplete="new-password"
                        >
                        @error('password')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group">
                        <label for="crear-rol">Rol</label>
                        <select id="crear-rol" name="rol" class="ap-input @error('rol') ap-input--error @enderror">
                            <option value="">Selecciona un rol</option>
                            @foreach (\App\Http\Controllers\Admin\UserController::ROLES as $rol)
                                <option value="{{ $rol }}" @selected(old('rol') === $rol)>
                                    {{ ucfirst($rol) }}
                                </option>
                            @endforeach
                        </select>
                        @error('rol')
                            <span class="ap-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="ap-form-group ap-form-group--checkbox">
                        <label>
                            <input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                            Usuario activo
                        </label>
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-usuario-crear')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Crear usuario</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── MODAL: EDITAR USUARIO ─────────────────────────────────────── --}}
    <div class="ap-modal-overlay" id="modal-usuario-editar">
        <div class="ap-modal">
            <h3>Editar usuario</h3>
            <form method="POST" id="form-editar-usuario" action="">
                @csrf
                @method('PUT')
                <div class="ap-form-grid" style="margin-top: 16px;">
                    <div class="ap-form-group">
                        <label for="editar-name">Nombre completo</label>
                        <input
                            type="text"
                            id="editar-name"
                            name="name"
                            class="ap-input"
                            autocomplete="off"
                        >
                    </div>
                    <div class="ap-form-group">
                        <label for="editar-email">Correo electrónico</label>
                        <input
                            type="email"
                            id="editar-email"
                            name="email"
                            class="ap-input"
                            autocomplete="off"
                        >
                    </div>
                    <div class="ap-form-group">
                        <label for="editar-password">
                            Nueva contraseña
                            <span class="ap-form-link" style="cursor: default;">Dejar vacío para no cambiar</span>
                        </label>
                        <input
                            type="password"
                            id="editar-password"
                            name="password"
                            class="ap-input"
                            placeholder="Dejar vacío para mantener actual"
                            autocomplete="new-password"
                        >
                    </div>
                    <div class="ap-form-group">
                        <label for="editar-rol">Rol</label>
                        <select id="editar-rol" name="rol" class="ap-input">
                            @foreach (\App\Http\Controllers\Admin\UserController::ROLES as $rol)
                                <option value="{{ $rol }}">
                                    {{ ucfirst($rol) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ap-form-group ap-form-group--checkbox">
                        <label>
                            <input type="checkbox" name="activo" value="1" id="editar-activo">
                            Usuario activo
                        </label>
                    </div>
                </div>
                <div class="ap-modal-actions">
                    <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-usuario-editar')">Cancelar</button>
                    <button type="submit" class="ap-btn ap-btn--primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Pre-popular modal de edición al hacer clic en "Editar"
    document.querySelectorAll('[data-edit-usuario]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editar-name').value  = btn.dataset.name;
            document.getElementById('editar-email').value = btn.dataset.email;
            document.getElementById('editar-rol').value   = btn.dataset.rol;
            document.getElementById('editar-activo').checked = btn.dataset.activo === '1';
            document.getElementById('editar-password').value = '';
            document.getElementById('form-editar-usuario').action = btn.dataset.url;
            openModal('modal-usuario-editar');
        });
    });

    // Si hay errores de validación, re-abrir el modal de creación automáticamente
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal('modal-usuario-crear'));
    @endif
</script>
@endpush
