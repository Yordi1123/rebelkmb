@csrf

<div class="ap-panel">
    <div class="ap-form-grid">

        <div class="ap-form-group">
            <label for="codigo">Código</label>
            <input
                type="text"
                id="codigo"
                name="codigo"
                class="ap-input @error('codigo') ap-input--error @enderror"
                value="{{ old('codigo', $tipo->codigo ?? '') }}"
                placeholder="Ej: YN, YF, KB"
                style="text-transform: uppercase;"
            >
            @error('codigo')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                class="ap-input @error('nombre') ap-input--error @enderror"
                value="{{ old('nombre', $tipo->nombre ?? '') }}"
                placeholder="Ej: Yogurt Natural"
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
                    <option value="{{ $categoria->id }}" @selected(old('categoria_id', $tipo->categoria_id ?? '') == $categoria->id)>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

    </div>

    <div class="ap-form-actions">
        <a href="{{ route('admin.tipos.index') }}" class="ap-btn ap-btn--secondary">Cancelar</a>
        <button type="submit" class="ap-btn ap-btn--primary">
            {{ isset($tipo) ? 'Guardar cambios' : 'Crear tipo' }}
        </button>
    </div>
</div>
