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
                value="{{ old('codigo', $producto->codigo ?? '') }}"
                placeholder="Ej: YGF-FRESA"
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
                value="{{ old('nombre', $producto->nombre ?? '') }}"
                placeholder="Ej: Yogurt Griego Fresa"
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
                    <option
                        value="{{ $categoria->id }}"
                        @selected(old('categoria_id', $producto->categoria_id ?? '') == $categoria->id)
                    >
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="tipo">Tipo</label>
            <input
                type="text"
                id="tipo"
                name="tipo"
                class="ap-input @error('tipo') ap-input--error @enderror"
                value="{{ old('tipo', $producto->tipo ?? '') }}"
                placeholder="Ej: yogurt_griego_frutado, kombucha"
            >
            @error('tipo')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="sabor">Sabor</label>
            <input
                type="text"
                id="sabor"
                name="sabor"
                class="ap-input @error('sabor') ap-input--error @enderror"
                value="{{ old('sabor', $producto->sabor ?? '') }}"
                placeholder="Ej: Fresa, Maracuyá"
            >
            @error('sabor')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="presentacion">Presentación</label>
            <input
                type="text"
                id="presentacion"
                name="presentacion"
                class="ap-input @error('presentacion') ap-input--error @enderror"
                value="{{ old('presentacion', $producto->presentacion ?? '') }}"
                placeholder="Ej: 1L, 150g"
            >
            @error('presentacion')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="unidad_medida">Unidad de medida</label>
            <input
                type="text"
                id="unidad_medida"
                name="unidad_medida"
                class="ap-input @error('unidad_medida') ap-input--error @enderror"
                value="{{ old('unidad_medida', $producto->unidad_medida ?? '') }}"
                placeholder="Ej: litros, gramos, unidades"
            >
            @error('unidad_medida')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group ap-form-group--checkbox">
            <label>
                <input
                    type="checkbox"
                    name="activo"
                    value="1"
                    @checked(old('activo', $producto->activo ?? true))
                >
                Producto activo
            </label>
        </div>

    </div>

    <div class="ap-form-actions">
        <a href="{{ route('admin.productos.index') }}" class="ap-btn ap-btn--secondary">Cancelar</a>
        <button type="submit" class="ap-btn ap-btn--primary">
            {{ isset($producto) ? 'Guardar cambios' : 'Crear producto' }}
        </button>
    </div>
</div>
