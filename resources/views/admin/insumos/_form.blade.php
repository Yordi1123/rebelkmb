@if (isset($insumo))
    <form method="POST" action="{{ route('admin.insumos.update', $insumo) }}">
        @method('PUT')
@else
    <form method="POST" action="{{ route('admin.insumos.store') }}">
@endif
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
                    <button type="button" class="ap-form-link" onclick="openModal('modal-ins-cat-crear')">+ Nueva categoría</button>
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
                <label for="proveedor_id">
                    Proveedor (opcional)
                    <button type="button" class="ap-form-link" onclick="openModal('modal-ins-prov-crear')">+ Nuevo proveedor</button>
                </label>
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
                    @if (isset($insumo)) readonly style="background: #f2f0ea; cursor: not-allowed;" @endif
                >
                @error('stock_actual')
                    <span class="ap-form-error">{{ $message }}</span>
                @enderror
                @if (isset($insumo))
                    <small style="color: #6b6355; font-size: 0.78rem;">
                        El stock actual solo se puede modificar mediante Compras o Despachos (trazabilidad). No se edita "a dedo" aquí.
                    </small>
                @endif
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
                    value="{{ old('stock_minimo', $insumo->stock_minimo ?? 5) }}"
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

</form>

{{-- ── MODAL: NUEVA CATEGORÍA DE INSUMO ─────────────────────────────────── --}}
{{-- Colocado DESPUÉS del </form> principal para evitar formularios anidados  --}}
<div class="ap-modal-overlay" id="modal-ins-cat-crear">
    <div class="ap-modal">
        <h3>Nueva categoría de insumo</h3>
        <form method="POST" action="{{ route('admin.categorias-insumo.store') }}" id="form-ins-cat-crear">
            @csrf
            <input type="hidden" name="_redirect_back" value="1">
            <div class="ap-form-grid" style="margin-top: 16px;">
                <div class="ap-form-group" style="grid-column: 1 / -1;">
                    <label for="ic-nombre">Nombre</label>
                    <input
                        type="text"
                        id="ic-nombre"
                        name="nombre"
                        class="ap-input"
                        placeholder="Ej: Lácteos, Envases, Cultivos"
                        autocomplete="off"
                    >
                </div>
                <div class="ap-form-group" style="grid-column: 1 / -1;">
                    <label for="ic-descripcion">Descripción (opcional)</label>
                    <input
                        type="text"
                        id="ic-descripcion"
                        name="descripcion"
                        class="ap-input"
                        autocomplete="off"
                    >
                </div>
            </div>
            <div class="ap-modal-actions">
                <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-ins-cat-crear')">Cancelar</button>
                <button type="submit" class="ap-btn ap-btn--primary">Crear categoría</button>
            </div>
        </form>
    </div>
</div>

<div class="ap-modal-overlay" id="modal-ins-prov-crear">
    <div class="ap-modal">
        <h3>Nuevo proveedor</h3>
        <form method="POST" action="{{ route('admin.proveedores.store') }}" id="form-ins-prov-crear">
            @csrf
            <div class="ap-form-grid" style="margin-top: 16px;">
                <div class="ap-form-group" style="grid-column: 1 / -1;">
                    <label for="prov-nombre">Nombre comercial</label>
                    <input type="text" id="prov-nombre" name="nombre" class="ap-input" placeholder="Ej: Envases S.A." required>
                </div>
                <div class="ap-form-group" style="grid-column: 1 / -1;">
                    <label for="prov-lead-time">Lead time (días de entrega)</label>
                    <input type="number" id="prov-lead-time" name="lead_time_dias" class="ap-input" value="0" min="0" required>
                </div>
            </div>
            <div class="ap-modal-actions">
                <button type="button" class="ap-btn ap-btn--secondary" onclick="closeModal('modal-ins-prov-crear')">Cancelar</button>
                <button type="submit" class="ap-btn ap-btn--primary">Crear proveedor</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupAjaxModal(formId, selectId, modalId) {
        const form = document.getElementById(formId);
        if (!form) return;
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById(selectId);
                    const option = new Option(data.data.nombre, data.data.id, true, true);
                    select.add(option);
                    closeModal(modalId);
                    form.reset();
                } else {
                    alert('Ocurrió un error al guardar. Verifica los datos.');
                }
            })
            .catch(error => {
                alert('Error de conexión.');
                console.error(error);
            });
        });
    }

    setupAjaxModal('form-ins-cat-crear', 'categoria_insumo_id', 'modal-ins-cat-crear');
    setupAjaxModal('form-ins-prov-crear', 'proveedor_id', 'modal-ins-prov-crear');
});
</script>
