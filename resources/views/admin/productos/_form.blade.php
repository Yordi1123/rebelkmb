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
                <button type="button" class="ap-form-link" onclick="openModal('modal-prod-cat-crear')">+ Nueva categoría</button>
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
                <button type="button" class="ap-form-link" onclick="openModal('modal-prod-tipo-crear')">+ Nuevo tipo</button>
            </label>
            <select id="tipo_id" name="tipo_id" class="ap-input @error('tipo_id') ap-input--error @enderror">
                <option value="">Selecciona una categoría primero</option>
                @foreach ($tipos as $tipo)
                    <option
                        value="{{ $tipo->id }}"
                        data-categoria="{{ $tipo->categoria_id }}"
                        data-requiere-sabor="{{ $tipo->requiere_sabor ? '1' : '0' }}"
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

        <div class="ap-form-group" id="sabor-group">
            <label for="sabor_id" id="sabor-label">
                Sabor
                <button type="button" class="ap-form-link" onclick="openModal('modal-prod-sabor-crear')">+ Nuevo sabor</button>
            </label>
            {{-- Badge de estado: se actualiza con JS --}}
            <span id="sabor-estado" style="
                display: none;
                font-size: 0.75rem;
                font-weight: 600;
                padding: 2px 10px;
                border-radius: 20px;
                margin-left: 6px;
            "></span>
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
            <small id="sabor-hint" style="color: #6b6355; font-size: 0.78rem;"></small>
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
        const tipoSelect      = document.getElementById('tipo_id');
        const saborSelect     = document.getElementById('sabor_id');
        const saborEstado     = document.getElementById('sabor-estado');
        const saborHint       = document.getElementById('sabor-hint');

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

        // ── Lógica de requiere_sabor ─────────────────────────────────────────
        // Bloquea o habilita el campo Sabor según el tipo seleccionado.
        function actualizarEstadoSabor() {
            const tipoOpt = tipoSelect.options[tipoSelect.selectedIndex];
            const requiere = tipoOpt && tipoOpt.dataset.requiereSabor === '1';

            if (!tipoSelect.value) {
                // Sin tipo seleccionado: sabor deshabilitado, sin indicador
                saborSelect.disabled = true;
                saborSelect.value    = '';
                saborEstado.style.display = 'none';
                saborHint.textContent = '';
                return;
            }

            if (requiere) {
                saborSelect.disabled = false;
                saborEstado.textContent = '* Requerido';
                saborEstado.style.display     = 'inline-block';
                saborEstado.style.background  = 'rgba(98,87,223,0.10)';
                saborEstado.style.color       = '#6257df';
                saborHint.textContent = 'Este tipo requiere que selecciones un sabor.';
            } else {
                saborSelect.disabled = true;
                saborSelect.value    = '';
                saborEstado.textContent = 'No aplica';
                saborEstado.style.display     = 'inline-block';
                saborEstado.style.background  = 'rgba(107,99,85,0.10)';
                saborEstado.style.color       = '#6b6355';
                saborHint.textContent = 'Este tipo no requiere sabor (ej: Natural, Griego).';
            }
        }

        function actualizarFiltros() {
            const categoriaId = categoriaSelect.value;
            filtrarPorCategoria(tipoSelect, categoriaId);
            filtrarPorCategoria(saborSelect, categoriaId);
            actualizarEstadoSabor();
        }

        categoriaSelect.addEventListener('change', actualizarFiltros);
        tipoSelect.addEventListener('change', actualizarEstadoSabor);

        // Al cargar la página (ej: modo edición con datos ya guardados),
        // aplica el filtro inmediatamente para que se vea consistente.
        actualizarFiltros();

        // En modo edición, si ya había un tipo/sabor guardado, aseguramos
        // que su opción quede visible aunque el filtro inicial la hubiera ocultado.
        const tipoSeleccionado = tipoSelect.querySelector('option[selected]');
        if (tipoSeleccionado) tipoSeleccionado.hidden = false;

        const saborSeleccionado = saborSelect.querySelector('option[selected]');
        if (saborSeleccionado) saborSeleccionado.hidden = false;

        // Aplicar estado del sabor después de restaurar las opciones seleccionadas
        actualizarEstadoSabor();
    })();
</script>

{{-- ── MODAL: NUEVA CATEGORÍA (desde formulario de producto) ─── --}}
<div class="ap-modal-overlay" id="modal-prod-cat-crear">
    <div class="ap-modal">
        <h3>Nueva categoría</h3>
        <form method="POST" action="{{ route('admin.categorias.store') }}">
            @csrf
            <input type="hidden" name="_redirect_back" value="1">
            <div class="ap-form-grid" style="margin-top:16px;">
                <div class="ap-form-group">
                    <label for="pc-nombre">Nombre</label>
                    <input type="text" id="pc-nombre" name="nombre" class="ap-input" placeholder="Ej: Yogures" autocomplete="off">
                </div>
                <div class="ap-form-group" style="grid-column:1/-1;">
                    <label for="pc-desc">Descripción (opcional)</label>
                    <input type="text" id="pc-desc" name="descripcion" class="ap-input" autocomplete="off">
                </div>
            </div>
            <div class="ap-modal-actions">
                <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-prod-cat-crear')">Cancelar</button>
                <button type="submit" class="ap-btn ap-btn--primary">Crear categoría</button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL: NUEVO TIPO (desde formulario de producto) ─────── --}}
<div class="ap-modal-overlay" id="modal-prod-tipo-crear">
    <div class="ap-modal">
        <h3>Nuevo tipo</h3>
        <form method="POST" action="{{ route('admin.tipos.store') }}">
            @csrf
            <input type="hidden" name="_redirect_back" value="1">
            <div class="ap-form-grid" style="margin-top:16px;">
                <div class="ap-form-group">
                    <label for="pt-codigo">Código</label>
                    <input type="text" id="pt-codigo" name="codigo" class="ap-input" placeholder="Ej: YN" style="text-transform:uppercase;" autocomplete="off">
                </div>
                <div class="ap-form-group">
                    <label for="pt-nombre">Nombre</label>
                    <input type="text" id="pt-nombre" name="nombre" class="ap-input" placeholder="Ej: Yogurt Natural" autocomplete="off">
                </div>
                <div class="ap-form-group" style="grid-column:1/-1;">
                    <label for="pt-categoria">Categoría</label>
                    <select id="pt-categoria" name="categoria_id" class="ap-input">
                        <option value="">Selecciona una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="ap-form-group ap-form-group--checkbox" style="grid-column:1/-1;">
                    <label>
                        <input type="checkbox" name="requiere_sabor" value="1">
                        Los productos de este tipo requieren un sabor
                        <small style="display:block; color:#6b6355; font-size:0.78rem; margin-top:2px; font-weight:400;">
                            Ej: Yogurt Frutado ✓ — Yogurt Natural ✗
                        </small>
                    </label>
                </div>
            </div>
            <div class="ap-modal-actions">
                <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-prod-tipo-crear')">Cancelar</button>
                <button type="submit" class="ap-btn ap-btn--primary">Crear tipo</button>
            </div>
        </form>
    </div>
</div>


{{-- ── MODAL: NUEVO SABOR (desde formulario de producto) ─────── --}}
<div class="ap-modal-overlay" id="modal-prod-sabor-crear">
    <div class="ap-modal">
        <h3>Nuevo sabor</h3>
        <form method="POST" action="{{ route('admin.sabores.store') }}">
            @csrf
            <input type="hidden" name="_redirect_back" value="1">
            <div class="ap-form-grid" style="margin-top:16px;">
                <div class="ap-form-group">
                    <label for="ps-nombre">Nombre</label>
                    <input type="text" id="ps-nombre" name="nombre" class="ap-input" placeholder="Ej: Fresa" autocomplete="off">
                </div>
                <div class="ap-form-group" style="grid-column:1/-1;">
                    <label for="ps-categoria">Categoría</label>
                    <select id="ps-categoria" name="categoria_id" class="ap-input">
                        <option value="">Selecciona una categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
