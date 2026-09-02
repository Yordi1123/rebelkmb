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
                value="{{ old('nombre', $sabor->nombre ?? '') }}"
                placeholder="Ej: Fresa, Maracuyá"
            >
            @error('nombre')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="categoria_id">Categoría</label>
            <select id="categoria_id" name="categoria_id" class="ap-input @error('categoria_id') ap-input--error @enderror">
                <option value="">Selecciona una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(old('categoria_id', $sabor->categoria_id ?? '') == $categoria->id)>
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

    <div class="ap-form-actions">
        <a href="{{ route('admin.sabores.index') }}" class="ap-btn ap-btn--secondary">Cancelar</a>
        <button type="submit" class="ap-btn ap-btn--primary">
            {{ isset($sabor) ? 'Guardar cambios' : 'Crear sabor' }}
        </button>
    </div>
</div>
