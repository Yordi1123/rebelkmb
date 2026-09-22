@csrf

<div class="ap-panel">
    <div class="ap-form-grid">
        <div class="ap-form-group">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                class="ap-input @error('nombre') ap-input--error @enderror"
                value="{{ old('nombre', $categoria->nombre ?? '') }}"
                placeholder="Ej: Envases y Empaques"
            >
            @error('nombre')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group" style="grid-column: 1 / -1;">
            <label for="descripcion">Descripción (opcional)</label>
            <input
                type="text"
                id="descripcion"
                name="descripcion"
                class="ap-input"
                value="{{ old('descripcion', $categoria->descripcion ?? '') }}"
            >
        </div>
    </div>

    <div class="ap-form-actions">
        <a href="{{ route('admin.categorias-insumo.index') }}" class="ap-btn ap-btn--secondary">Cancelar</a>
        <button type="submit" class="ap-btn ap-btn--primary">
            {{ isset($categoria) ? 'Guardar cambios' : 'Crear categoría' }}
        </button>
    </div>
</div>
