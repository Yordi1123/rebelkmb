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
                value="{{ old('codigo', $insumo->codigo ?? '') }}"
                placeholder="Ej: AGUA, AZUC, BOT330"
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
                value="{{ old('nombre', $insumo->nombre ?? '') }}"
                placeholder="Ej: Azúcar, Cultivo Yogurt, Botella 330ml"
            >
            @error('nombre')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="categoria_insumo_id">
                Categoría
                <a href="{{ route('admin.categorias-insumo.create') }}" target="_blank" class="ap-form-link">+ Nueva categoría</a>
            </label>
            <select id="categoria_insumo_id" name="categoria_insumo_id" class="ap-input @error('categoria_insumo_id') ap-input--error @enderror">
                <option value="">Selecciona una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(old('categoria_insumo_id', $insumo->categoria_insumo_id ?? '') == $categoria->id)>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_insumo_id')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="proveedor_id">Proveedor (opcional)</label>
            <select id="proveedor_id" name="proveedor_id" class="ap-input">
                <option value="">Sin proveedor asignado</option>
                @foreach ($proveedores ?? [] as $proveedor)
                    <option
                        value="{{ $proveedor->id }}"
                        @selected(old('proveedor_id', $insumo->proveedor_id ?? '') == $proveedor->id)
                    >
                        {{ $proveedor->nombre ?? $proveedor->razon_social ?? 'Proveedor #' . $proveedor->id }}
                    </option>
                @endforeach
            </select>
            <small style="color: #6b6355; font-size: 0.78rem;">
                Este dropdown quedará vacío hasta que el módulo de Proveedores de Franco esté fusionado.
            </small>
        </div>

        <div class="ap-form-group">
            <label for="unidad_medida">Unidad de medida</label>
            <select id="unidad_medida" name="unidad_medida" class="ap-input @error('unidad_medida') ap-input--error @enderror">
                <option value="">Selecciona una unidad</option>
                @foreach (\App\Models\Insumo::UNIDADES as $unidad)
                    <option value="{{ $unidad }}" @selected(old('unidad_medida', $insumo->unidad_medida ?? '') == $unidad)>
                        {{ ucfirst($unidad) }}
                    </option>
                @endforeach
            </select>
            @error('unidad_medida')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="stock_actual">Stock actual</label>
            <input
                type="number"
                step="0.01"
                min="0"
                id="stock_actual"
                name="stock_actual"
                class="ap-input @error('stock_actual') ap-input--error @enderror"
                value="{{ old('stock_actual', $insumo->stock_actual ?? 0) }}"
            >
            @error('stock_actual')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="stock_minimo">Stock mínimo</label>
            <input
                type="number"
                step="0.01"
                min="0"
                id="stock_minimo"
                name="stock_minimo"
                class="ap-input @error('stock_minimo') ap-input--error @enderror"
                value="{{ old('stock_minimo', $insumo->stock_minimo ?? 0) }}"
            >
            @error('stock_minimo')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
            <small style="color: #6b6355; font-size: 0.78rem;">
                Cuando el stock actual llegue a este valor o menos, se marcará como "Stock bajo".
            </small>
        </div>

        <div class="ap-form-group">
            <label for="stock_seguridad">Stock de seguridad (opcional)</label>
            <input
                type="number"
                step="0.01"
                min="0"
                id="stock_seguridad"
                name="stock_seguridad"
                class="ap-input @error('stock_seguridad') ap-input--error @enderror"
                value="{{ old('stock_seguridad', $insumo->stock_seguridad ?? '') }}"
            >
            <small style="color: #6b6355; font-size: 0.78rem;">
                Colchón extra para imprevistos — se usará más adelante en el módulo de MRP.
            </small>
        </div>

        <div class="ap-form-group ap-form-group--checkbox">
            <label>
                <input type="checkbox" name="activo" value="1" @checked(old('activo', $insumo->activo ?? true))>
                Insumo activo
            </label>
        </div>

    </div>

    <div class="ap-form-actions">
        <a href="{{ route('admin.insumos.index') }}" class="ap-btn ap-btn--secondary">Cancelar</a>
        <button type="submit" class="ap-btn ap-btn--primary">
            {{ isset($insumo) ? 'Guardar cambios' : 'Crear insumo' }}
        </button>
    </div>
</div>
