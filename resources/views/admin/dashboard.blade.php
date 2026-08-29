@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

{{-- ============================================================
     SECCIÓN: DASHBOARD
     ============================================================ --}}
<section class="ap-section ap-section--active" id="dashboard">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">CENTRO DE CONTROL</p>
      <h1>Dashboard general</h1>
      <p>Monitorea demanda, abastecimiento, producción e inventario en un solo lugar.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('Datos actualizados correctamente')">
      ↻ Actualizar datos
    </button>
  </div>

  {{-- KPIs principales --}}
  <div class="ap-kpi-grid">
    <div class="ap-kpi-card">
      <div class="ap-kpi-icon ap-kpi-icon--purple">▣</div>
      <div>
        <span>Pedidos activos</span>
        <strong>{{ $kpis['pedidos_activos'] }}</strong>
        <small class="ap-up">↑ Sistema en línea</small>
      </div>
    </div>
    <div class="ap-kpi-card">
      <div class="ap-kpi-icon ap-kpi-icon--blue">▦</div>
      <div>
        <span>Órdenes de producción</span>
        <strong>{{ $kpis['ordenes_produccion'] }}</strong>
        <small class="ap-up">↑ Registradas</small>
      </div>
    </div>
    <div class="ap-kpi-card">
      <div class="ap-kpi-icon ap-kpi-icon--orange">◉</div>
      <div>
        <span>Lotes activos</span>
        <strong>{{ $kpis['lotes_activos'] }}</strong>
        <small class="ap-up">↑ En trazabilidad</small>
      </div>
    </div>
    <div class="ap-kpi-card">
      <div class="ap-kpi-icon ap-kpi-icon--green">✓</div>
      <div>
        <span>Productos registrados</span>
        <strong>{{ $kpis['total_productos'] }}</strong>
        <small class="ap-up">↑ Catálogo activo</small>
      </div>
    </div>
  </div>

  {{-- Gráficos: demanda e inventario --}}
  <div class="ap-grid-2">
    <div class="ap-panel ap-chart-panel">
      <div class="ap-panel-head">
        <div><h2>Demanda vs. Pronóstico</h2><span>Últimos 8 periodos</span></div>
        <select class="ap-select"><option>Mensual</option><option>Semanal</option></select>
      </div>
      <canvas id="demandChart"></canvas>
    </div>
    <div class="ap-panel ap-chart-panel">
      <div class="ap-panel-head">
        <div><h2>Estado del inventario</h2><span>Por categoría</span></div>
        <button class="ap-more-btn">•••</button>
      </div>
      <canvas id="inventoryChart"></canvas>
    </div>
  </div>

  {{-- Flujo y alertas --}}
  <div class="ap-grid-2 ap-lower">
    <div class="ap-panel">
      <div class="ap-panel-head">
        <div><h2>Flujo de planificación</h2><span>Estado actual del proceso</span></div>
      </div>
      <div class="ap-flow">
        <div class="ap-flow-item ap-flow-item--done"><b>01</b><span>Pedidos</span><strong>{{ $kpis['pedidos_activos'] }}</strong></div>
        <div class="ap-flow-line"></div>
        <div class="ap-flow-item ap-flow-item--done"><b>02</b><span>Pronóstico</span><strong>—</strong></div>
        <div class="ap-flow-line"></div>
        <div class="ap-flow-item ap-flow-item--current"><b>03</b><span>MPS</span><strong>—</strong></div>
        <div class="ap-flow-line"></div>
        <div class="ap-flow-item"><b>04</b><span>MRP</span><strong>—</strong></div>
        <div class="ap-flow-line"></div>
        <div class="ap-flow-item"><b>05</b><span>Compras</span><strong>—</strong></div>
      </div>
    </div>
    <div class="ap-panel">
      <div class="ap-panel-head">
        <div><h2>Alertas operativas</h2><span>Requieren atención</span></div>
        <span class="ap-badge ap-badge--danger">Sistema iniciado</span>
      </div>
      <div class="ap-alerts">
        <div class="ap-alert">
          <span class="ap-alert-dot ap-alert-dot--green"></span>
          <div><strong>Base de datos</strong><p>rebelkmb_db · {{ $kpis['total_tablas'] }} tablas activas</p></div>
          <b>OK</b>
        </div>
        <div class="ap-alert">
          <span class="ap-alert-dot ap-alert-dot--green"></span>
          <div><strong>Usuarios activos</strong><p>{{ $kpis['usuarios_activos'] }} usuario(s) en el sistema</p></div>
          <b>OK</b>
        </div>
        <div class="ap-alert">
          <span class="ap-alert-dot ap-alert-dot--yellow"></span>
          <div><strong>Módulos pendientes</strong><p>Datos de producción aún no cargados</p></div>
          <b>Próximo</b>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: PEDIDOS
     ============================================================ --}}
<section class="ap-section" id="pedidos">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">DEMANDA</p>
      <h1>Pedidos / Ventas</h1>
      <p>Captura y seguimiento de la demanda de clientes.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('Módulo disponible en próxima entrega')">+ Nuevo pedido</button>
  </div>
  <div class="ap-stats-row">
    <div class="ap-mini-stat"><span>Total pedidos</span><strong>{{ $kpis['pedidos_activos'] }}</strong></div>
    <div class="ap-mini-stat"><span>En proceso</span><strong>—</strong></div>
    <div class="ap-mini-stat"><span>Despachados</span><strong>—</strong></div>
    <div class="ap-mini-stat"><span>Cancelados</span><strong>—</strong></div>
  </div>
  <div class="ap-panel ap-table-panel">
    <div class="ap-panel-head">
      <div><h2>Pedidos recientes</h2><span>Sin datos aún — se cargarán en el módulo de ventas</span></div>
      <input class="ap-search" placeholder="Buscar pedido...">
    </div>
    <div class="ap-empty-state">
      <p>📋 Los pedidos se registrarán en la siguiente fase del sistema.</p>
    </div>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: PRONÓSTICOS
     ============================================================ --}}
<section class="ap-section" id="pronosticos">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">PLANIFICACIÓN</p>
      <h1>Pronósticos de demanda</h1>
      <p>Estima la demanda futura y controla el método de pronóstico.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('Pronóstico recalculado')">↻ Recalcular</button>
  </div>
  <div class="ap-grid-2">
    <div class="ap-panel ap-chart-panel ap-chart-panel--tall">
      <div class="ap-panel-head">
        <div><h2>Pronóstico por periodo</h2><span>Método: Promedio móvil ponderado</span></div>
      </div>
      <canvas id="forecastChart"></canvas>
    </div>
    <div class="ap-panel ap-parameter-panel">
      <h2>Parámetros</h2>
      <div class="ap-form-grid">
        <label>Periodo de pronóstico
          <select class="ap-select"><option>12 meses</option><option>6 meses</option><option>3 meses</option></select>
        </label>
        <label>Método
          <select class="ap-select"><option>Promedio móvil ponderado</option><option>Suavización exponencial</option><option>Regresión lineal</option></select>
        </label>
        <label>α de suavización<input class="ap-input" value="0.35"></label>
        <label>Horizonte<input class="ap-input" value="8 periodos"></label>
      </div>
      <div class="ap-accuracy">
        <span>Precisión del modelo</span>
        <strong>—</strong>
        <div class="ap-progress"><i style="width:0%"></i></div>
      </div>
    </div>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: MPS
     ============================================================ --}}
<section class="ap-section" id="mps">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">PLAN MAESTRO</p>
      <h1>MPS — Plan Maestro de Producción</h1>
      <p>Convierte la demanda en un programa de producción.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('MPS generado para los próximos 30 días')">Generar MPS</button>
  </div>
  <div class="ap-panel ap-table-panel">
    <div class="ap-panel-head">
      <div><h2>Programa maestro</h2><span>Próximos 14 días</span></div>
      <span class="ap-badge ap-badge--blue">MPS pendiente</span>
    </div>
    <div class="ap-empty-state">
      <p>📅 El MPS se generará cuando existan pedidos y pronósticos registrados.</p>
    </div>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: MRP
     ============================================================ --}}
<section class="ap-section" id="mrp">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">ABASTECIMIENTO</p>
      <h1>MRP — Planificación de materiales</h1>
      <p>Calcula necesidades, órdenes de compra y fechas de abastecimiento.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('MRP ejecutado correctamente')">Ejecutar MRP</button>
  </div>
  <div class="ap-kpi-grid ap-kpi-grid--three">
    <div class="ap-kpi-card"><div class="ap-kpi-icon ap-kpi-icon--orange">!</div><div><span>Necesidades netas</span><strong>—</strong></div></div>
    <div class="ap-kpi-card"><div class="ap-kpi-icon ap-kpi-icon--blue">⇄</div><div><span>Órdenes sugeridas</span><strong>—</strong></div></div>
    <div class="ap-kpi-card"><div class="ap-kpi-icon ap-kpi-icon--green">✓</div><div><span>Abastecimiento</span><strong>—</strong></div></div>
  </div>
  <div class="ap-panel ap-table-panel">
    <div class="ap-panel-head">
      <div><h2>Requerimientos de materiales</h2><span>Según BOM + MPS + inventario</span></div>
    </div>
    <div class="ap-empty-state">
      <p>⚙️ El MRP se calculará automáticamente cuando el MPS esté confirmado.</p>
    </div>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: INVENTARIOS
     ============================================================ --}}
<section class="ap-section" id="inventarios">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">CONTROL</p>
      <h1>Inventarios</h1>
      <p>Control de existencias, stock mínimo y stock de seguridad.</p>
    </div>
    <button class="ap-btn ap-btn--secondary" onclick="showToast('Inventario sincronizado')">⟳ Sincronizar</button>
  </div>
  <div class="ap-grid-2">
    <div class="ap-panel ap-chart-panel">
      <div class="ap-panel-head"><div><h2>Niveles de inventario</h2><span>Últimos 30 días</span></div></div>
      <canvas id="stockChart"></canvas>
    </div>
    <div class="ap-panel">
      <div class="ap-panel-head"><div><h2>Indicadores</h2><span>Situación actual</span></div></div>
      <div class="ap-indicator-list">
        <div><span>Rotación de inventario</span><strong>—</strong></div>
        <div><span>Cobertura promedio</span><strong>—</strong></div>
        <div><span>Stock de seguridad</span><strong>—</strong></div>
        <div><span>Quiebres de stock</span><strong>—</strong></div>
      </div>
    </div>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: COMPRAS
     ============================================================ --}}
<section class="ap-section" id="compras">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">ABASTECIMIENTO</p>
      <h1>Compras y proveedores</h1>
      <p>Gestiona órdenes de compra y lead time de proveedores.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('Módulo disponible en próxima entrega')">+ Nueva compra</button>
  </div>
  <div class="ap-panel ap-table-panel">
    <div class="ap-panel-head">
      <div><h2>Órdenes de compra</h2><span>Seguimiento de abastecimiento</span></div>
    </div>
    <div class="ap-empty-state">
      <p>🛒 Las órdenes de compra se registrarán conforme se ejecute el MRP.</p>
    </div>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: PRODUCCIÓN
     ============================================================ --}}
<section class="ap-section" id="produccion">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">OPERACIONES</p>
      <h1>Producción</h1>
      <p>Ejecuta y monitorea el plan de producción.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('Módulo disponible en próxima entrega')">+ Orden de producción</button>
  </div>
  <div class="ap-kpi-grid">
    <div class="ap-kpi-card"><div class="ap-kpi-icon ap-kpi-icon--blue">▦</div><div><span>OP activas</span><strong>{{ $kpis['ordenes_produccion'] }}</strong></div></div>
    <div class="ap-kpi-card"><div class="ap-kpi-icon ap-kpi-icon--green">✓</div><div><span>Avance promedio</span><strong>—</strong></div></div>
    <div class="ap-kpi-card"><div class="ap-kpi-icon ap-kpi-icon--orange">◷</div><div><span>Lotes producidos</span><strong>{{ $kpis['lotes_activos'] }}</strong></div></div>
    <div class="ap-kpi-card"><div class="ap-kpi-icon ap-kpi-icon--purple">◉</div><div><span>Productos</span><strong>{{ $kpis['total_productos'] }}</strong></div></div>
  </div>
  <div class="ap-panel ap-chart-panel">
    <div class="ap-panel-head"><div><h2>Producción planificada vs. real</h2><span>Semana actual</span></div></div>
    <canvas id="productionChart"></canvas>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: LOTES / TRAZABILIDAD
     ============================================================ --}}
<section class="ap-section" id="lotes">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">CALIDAD</p>
      <h1>Lotes y trazabilidad</h1>
      <p>Rastrea materias primas, producción y producto terminado.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('Módulo disponible en próxima entrega')">+ Registrar lote</button>
  </div>
  <div class="ap-panel ap-table-panel">
    <div class="ap-panel-head">
      <div><h2>Trazabilidad de lotes</h2><span>Cadena completa de producción</span></div>
      <input class="ap-search" placeholder="Buscar lote... (ej: KB-MR-170426)">
    </div>
    <div class="ap-empty-state">
      <p>◉ Los lotes de Yogurt y Kombucha se registrarán en el módulo de producción.</p>
    </div>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: PRODUCTO TERMINADO
     ============================================================ --}}
<section class="ap-section" id="terminados">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">SALIDA</p>
      <h1>Producto terminado</h1>
      <p>Controla existencias listas para despacho.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('Módulo disponible en próxima entrega')">+ Generar despacho</button>
  </div>
  <div class="ap-grid-2">
    <div class="ap-panel ap-chart-panel">
      <div class="ap-panel-head"><div><h2>Producto terminado</h2><span>Disponibilidad por producto</span></div></div>
      <canvas id="finishedChart"></canvas>
    </div>
    <div class="ap-panel">
      <div class="ap-panel-head"><div><h2>Próximos despachos</h2><span>Pendientes de asignar</span></div></div>
      <div class="ap-empty-state">
        <p>✓ Los despachos se registrarán cuando haya producto terminado disponible.</p>
      </div>
    </div>
  </div>
</section>

{{-- ============================================================
     SECCIÓN: REPORTES
     ============================================================ --}}
<section class="ap-section" id="reportes">
  <div class="ap-page-heading">
    <div>
      <p class="ap-eyebrow">ANÁLISIS</p>
      <h1>Reportes e indicadores</h1>
      <p>Genera evidencia para el seguimiento y control de gestión.</p>
    </div>
    <button class="ap-btn ap-btn--primary" onclick="showToast('Reporte generado en PDF')">↓ Generar reporte</button>
  </div>
  <div class="ap-report-grid">
    <div class="ap-report-card">
      <span>▥</span>
      <h3>Reporte de demanda</h3>
      <p>Pedidos, tendencia y precisión del pronóstico.</p>
      <button onclick="showToast('Disponible cuando existan datos de demanda')">Ver reporte →</button>
    </div>
    <div class="ap-report-card">
      <span>◫</span>
      <h3>Reporte MPS / MRP</h3>
      <p>Plan maestro y necesidades de materiales.</p>
      <button onclick="showToast('Disponible cuando se genere el MPS')">Ver reporte →</button>
    </div>
    <div class="ap-report-card">
      <span>▤</span>
      <h3>Reporte de inventarios</h3>
      <p>Stock mínimo, seguridad, rotación y quiebres.</p>
      <button onclick="showToast('Disponible cuando existan movimientos')">Ver reporte →</button>
    </div>
    <div class="ap-report-card">
      <span>✓</span>
      <h3>Reporte de producción</h3>
      <p>Avance, lotes, cumplimiento y despacho.</p>
      <button onclick="showToast('Disponible cuando existan lotes registrados')">Ver reporte →</button>
    </div>
  </div>
</section>

@endsection
