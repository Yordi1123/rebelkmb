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
                value="{{ old('nombre', $producto->nombre ?? '') }}"
                placeholder="Ej: Yogurt Griego Fresa"
            >
            @error('nombre')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="categoria_id">
                Categoría
                <a href="{{ route('admin.categorias.create') }}" target="_blank" class="ap-form-link">+ Nueva categoría</a>
            </label>
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
            <label for="tipo_id">
                Código / Tipo
                <a href="{{ route('admin.tipos.create') }}" target="_blank" class="ap-form-link">+ Nuevo tipo</a>
            </label>
            <select id="tipo_id" name="tipo_id" class="ap-input @error('tipo_id') ap-input--error @enderror">
                <option value="">Selecciona una categoría primero</option>
                @foreach ($tipos as $tipo)
                    <option
                        value="{{ $tipo->id }}"
                        data-categoria="{{ $tipo->categoria_id }}"
                        @selected(old('tipo_id', $producto->tipo_id ?? '') == $tipo->id)
                    >
                        {{ $tipo->codigo }} — {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('tipo_id')
                <span class="ap-form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="ap-form-group">
            <label for="sabor_id">
                Sabor
                <a href="{{ route('admin.sabores.create') }}" target="_blank" class="ap-form-link">+ Nuevo sabor</a>
            </label>
            <select id="sabor_id" name="sabor_id" class="ap-input @error('sabor_id') ap-input--error @enderror">
                <option value="">Sin sabor (ej: Natural, Griego)</option>
                @foreach ($sabores as $sabor)
                    <option
                        value="{{ $sabor->id }}"
                        data-categoria="{{ $sabor->categoria_id }}"
                        @selected(old('sabor_id', $producto->sabor_id ?? '') == $sabor->id)
                    >
                        {{ $sabor->nombre }}
                    </option>
                @endforeach
            </select>
            @error('sabor_id')
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
                placeholder="Ej: 1L, 150ml, 330ml"
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
                placeholder="Ej: litros, mililitros"
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

<script>
    // Filtra las opciones de Tipo y Sabor según la Categoría seleccionada.
    // Es un filtrado simple en el navegador (sin llamadas al servidor), suficiente
    // porque los catálogos de tipos/sabores son cortos.
    (function () {
        const categoriaSelect = document.getElementById('categoria_id');
        const tipoSelect = document.getElementById('tipo_id');
        const saborSelect = document.getElementById('sabor_id');

        function filtrarPorCategoria(select, categoriaId, placeholderTexto) {
            const opciones = select.querySelectorAll('option[data-categoria]');
            let hayAlgunaVisible = false;

            opciones.forEach(opcion => {
                const coincide = opcion.dataset.categoria === categoriaId;
                opcion.hidden = !coincide;

                // Si la opción que estaba seleccionada ya no corresponde a la
                // nueva categoría, la deseleccionamos para no guardar un dato inválido.
                if (!coincide && opcion.selected) {
                    opcion.selected = false;
                }
                if (coincide) hayAlgunaVisible = true;
            });

            // El placeholder (ej: "Selecciona una categoría primero") solo se
            // muestra si aún no se eligió categoría.
            const placeholder = select.querySelector('option[value=""]');
            if (placeholder) {
                placeholder.hidden = !!categoriaId;
                if (!categoriaId) placeholder.selected = true;
            }

            select.disabled = !categoriaId;
        }

        function actualizarFiltros() {
            const categoriaId = categoriaSelect.value;
            filtrarPorCategoria(tipoSelect, categoriaId);
            filtrarPorCategoria(saborSelect, categoriaId);
        }

        categoriaSelect.addEventListener('change', actualizarFiltros);

        // Al cargar la página (ej: modo edición con datos ya guardados),
        // aplica el filtro inmediatamente para que se vea consistente.
        actualizarFiltros();

        // En modo edición, si ya había un tipo/sabor guardado, aseguramos
        // que su opción quede visible aunque el filtro inicial la hubiera ocultado.
        const tipoSeleccionado = tipoSelect.querySelector('option[selected]');
        if (tipoSeleccionado) tipoSeleccionado.hidden = false;

        const saborSeleccionado = saborSelect.querySelector('option[selected]');
        if (saborSeleccionado) saborSeleccionado.hidden = false;
    })();
</script>
