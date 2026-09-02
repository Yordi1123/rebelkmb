<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="PlanFlow ERP — Panel de administración REBEL Kombucha">
  <title>@yield('title', 'Dashboard') — PlanFlow · REBEL Kombucha</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  {{-- Chart.js desde CDN (requerido por la plantilla) --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">


  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('styles')
</head>
<body class="admin-panel">
  <div class="ap-app">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="ap-sidebar" id="sidebar">
      <div class="ap-brand">
        <img src="{{ asset('images/rebel-logo.png') }}" alt="REBEL Kombucha" class="ap-brand__logo">
        <div class="ap-brand__text">
          <strong>PlanFlow</strong>
          <span>ERP Producción</span>
        </div>
      </div>

      <div class="ap-company">
        <span>Empresa</span>
        <strong>REBEL Kombucha</strong>
        <small>● Operación normal</small>
      </div>

      <nav class="ap-nav">
        <p class="ap-nav__title">PRINCIPAL</p>
        <button
          class="ap-nav__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
          data-section="dashboard"
        >
          <span class="ap-nav__icon">⌂</span>
          <span>Dashboard</span>
        </button>
        <button class="ap-nav__item" data-section="pedidos">
          <span class="ap-nav__icon">▣</span>
          <span>Pedidos / Ventas</span>
        </button>
        <button class="ap-nav__item" data-section="pronosticos">
          <span class="ap-nav__icon">◔</span>
          <span>Pronósticos</span>
        </button>
        <button class="ap-nav__item" data-section="mps">
          <span class="ap-nav__icon">◫</span>
          <span>MPS</span>
        </button>
        <button class="ap-nav__item" data-section="mrp">
          <span class="ap-nav__icon">⚙</span>
          <span>MRP</span>
        </button>

        <p class="ap-nav__title">OPERACIONES</p>
        <a
          href="{{ route('admin.productos.index') }}"
          class="ap-nav__item {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}"
        >
          <span class="ap-nav__icon">▤</span>
          <span>Catálogo de Productos</span>
        </a>
        <button class="ap-nav__item" data-section="compras">
          <span class="ap-nav__icon">⇄</span>
          <span>Compras</span>
        </button>
        <button class="ap-nav__item" data-section="produccion">
          <span class="ap-nav__icon">▦</span>
          <span>Producción</span>
        </button>
        <button class="ap-nav__item" data-section="lotes">
          <span class="ap-nav__icon">◉</span>
          <span>Lotes / Trazabilidad</span>
        </button>
        <button class="ap-nav__item" data-section="terminados">
          <span class="ap-nav__icon">✓</span>
          <span>Producto terminado</span>
        </button>

        <p class="ap-nav__title">GESTIÓN</p>
        <button class="ap-nav__item" data-section="reportes">
          <span class="ap-nav__icon">▥</span>
          <span>Reportes</span>
        </button>
      </nav>

      <div class="ap-sidebar__footer">
        <div class="ap-user-avatar">
          {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div class="ap-user-info">
          <strong>{{ auth()->user()->name }}</strong>
          <span>{{ ucfirst(auth()->user()->rol) }}</span>
        </div>
        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="ap-logout-form">
          @csrf
          <button type="submit" class="ap-icon-btn" title="Cerrar sesión">⏻</button>
        </form>
      </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <main class="ap-main">
      <header class="ap-topbar">
        <button class="ap-mobile-menu" id="mobileMenu" aria-label="Abrir menú">☰</button>
        <div class="ap-breadcrumbs">
          <span>Inicio</span>
          <b>/</b>
          <strong id="breadcrumb">@yield('breadcrumb', 'Dashboard')</strong>
        </div>
        <div class="ap-top-actions">
          <button class="ap-icon-btn ap-notification" aria-label="Notificaciones">
            ♢<i></i>
          </button>
          <div class="ap-date-chip" id="currentDate"></div>
        </div>
      </header>

      <div class="ap-content">
        @yield('content')
      </div>
    </main>

  </div>

  {{-- Toast global --}}
  <div class="ap-toast" id="toast" role="status" aria-live="polite">Operación realizada</div>

  {{-- Modal de confirmación reutilizable para acciones destructivas --}}
    <div class="ap-modal-overlay" id="confirmModalOverlay">
        <div class="ap-modal">
            <h3>¿Confirmar acción?</h3>
            <p id="confirmModalMessage">Esta acción no se puede deshacer.</p>
            <div class="ap-modal-actions">
                <button type="button" class="ap-btn ap-btn--secondary" id="confirmModalCancel">Cancelar</button>
                <button type="button" class="ap-btn ap-btn--danger" id="confirmModalAccept">Eliminar</button>
            </div>
        </div>
    </div>

  {{-- Script del panel --}}
  <script>
    // Fecha actual dinámica
    const dateEl = document.getElementById('currentDate');
    if (dateEl) {
      dateEl.textContent = new Date().toLocaleDateString('es-PE', {
        day: '2-digit', month: 'short', year: 'numeric'
      }).toUpperCase();
    }

    // Navegación entre secciones SPA
    const navItems  = document.querySelectorAll('.ap-nav__item');
    const sections  = document.querySelectorAll('.ap-section');
    const breadcrumb = document.getElementById('breadcrumb');
    const sidebar   = document.getElementById('sidebar');

    const sectionNames = {
      dashboard:   'Dashboard',
      pedidos:     'Pedidos / Ventas',
      pronosticos: 'Pronósticos',
      mps:         'MPS',
      mrp:         'MRP',
      inventarios: 'Inventarios',
      compras:     'Compras',
      produccion:  'Producción',
      lotes:       'Lotes / Trazabilidad',
      terminados:  'Producto terminado',
      reportes:    'Reportes',
    };

    navItems.forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = btn.dataset.section;
        if (!id) return; // Es un enlace normal con href
        
        // Prevenir comportamiento default por si acaso
        e.preventDefault();

        // Si estamos en el dashboard (existen las secciones)
        if (document.getElementById(id)) {
            navItems.forEach(x => x.classList.remove('active'));
            btn.classList.add('active');
            sections.forEach(s => s.classList.toggle('ap-section--active', s.id === id));
            if (breadcrumb) breadcrumb.textContent = sectionNames[id] || id;
            sidebar.classList.remove('open');
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setTimeout(initCharts, 30);
            history.replaceState(null, null, '{{ route('admin.dashboard') }}#' + id);
        } else {
            // Estamos en otra página, redirigir al dashboard con hash
            window.location.href = '{{ route('admin.dashboard') }}#' + id;
        }
      });
    });

    document.getElementById('mobileMenu')?.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });

    // Toast
    function showToast(msg) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), 2400);
    }

    // ── Modales genéricos ────────────────────────────────────────────────────
    function openModal(id) {
      const overlay = document.getElementById(id);
      if (!overlay) return;
      overlay.classList.add('ap-modal-overlay--open');
      // Foco en el primer input para accesibilidad
      setTimeout(() => {
        const firstInput = overlay.querySelector('input:not([type=hidden]), select, textarea');
        if (firstInput) firstInput.focus();
      }, 80);
    }
    function closeModal(id) {
      const overlay = document.getElementById(id);
      if (overlay) overlay.classList.remove('ap-modal-overlay--open');
    }
    // Cerrar cualquier modal al hacer clic fuera del contenido
    document.addEventListener('click', (e) => {
      if (e.target.classList.contains('ap-modal-overlay')) {
        e.target.classList.remove('ap-modal-overlay--open');
      }
    });
    // Cerrar con Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        document.querySelectorAll('.ap-modal-overlay--open').forEach(el => {
          el.classList.remove('ap-modal-overlay--open');
        });
      }
    });

    // Charts — idénticos a la plantilla original
    let charts = {};
    const chartDefaults = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: { font: { size: 9 }, usePointStyle: true, boxWidth: 7, color: '#7d8596' }
        }
      },
      scales: {
        x: { grid: { display: false }, ticks: { font: { size: 8 }, color: '#9aa1b0' } },
        y: { grid: { color: '#f0f1f5' }, ticks: { font: { size: 8 }, color: '#9aa1b0' } }
      }
    };

    function makeChart(id, type, data, options = {}) {
      const el = document.getElementById(id);
      if (!el) return;
      if (charts[id]) charts[id].destroy();
      charts[id] = new Chart(el, { type, data, options: { ...chartDefaults, ...options } });
    }

    function initCharts() {
      makeChart('demandChart', 'line', {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'],
        datasets: [
          { label: 'Demanda real',  data: [720, 810, 760, 930, 1010, 980, 1120, 1180], borderWidth: 2, tension: .35, pointRadius: 2, borderColor: '#6257df' },
          { label: 'Pronóstico',    data: [700, 780, 790, 880, 970, 1000, 1080, 1150], borderWidth: 2, tension: .35, borderDash: [5,4], pointRadius: 1, borderColor: '#e6963c' }
        ]
      });
      makeChart('inventoryChart', 'doughnut', {
        labels: ['Materia prima', 'Prod. terminado', 'Empaques', 'Otros'],
        datasets: [{ data: [46, 28, 16, 10], borderWidth: 0, backgroundColor: ['#6257df','#2aa873','#e6963c','#b0b8cc'] }]
      }, { cutout: '70%', plugins: { legend: { position: 'bottom' } }, scales: { x: { display: false }, y: { display: false } } });
      makeChart('forecastChart', 'line', {
        labels: ['Sep', 'Oct', 'Nov', 'Dic', 'Ene', 'Feb', 'Mar', 'Abr'],
        datasets: [
          { label: 'Histórico', data: [1150,1190,1220,1280,1310,1360,1410,1450], borderWidth: 2, tension: .3, borderColor: '#6257df' },
          { label: 'Pronóstico', data: [1200,1240,1290,1340,1380,1430,1480,1530], borderWidth: 2, tension: .3, borderDash: [5,4], borderColor: '#e6963c' }
        ]
      });
      makeChart('stockChart', 'line', {
        labels: ['01','05','10','15','20','25','30'],
        datasets: [
          { label: 'Stock disponible', data: [82,79,75,81,77,73,76], borderWidth: 2, tension: .35, fill: true, borderColor: '#6257df', backgroundColor: 'rgba(98,87,223,0.08)' },
          { label: 'Stock mínimo', data: [55,55,55,55,55,55,55], borderWidth: 1, borderDash: [4,4], tension: 0, borderColor: '#e6963c' }
        ]
      });
      makeChart('productionChart', 'bar', {
        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        datasets: [
          { label: 'Planificado', data: [1200,1350,1400,1500,1450,980], borderRadius: 4, backgroundColor: '#6257df' },
          { label: 'Real', data: [1160,1290,1370,1420,1410,920], borderRadius: 4, backgroundColor: '#2aa873' }
        ]
      });
      makeChart('finishedChart', 'doughnut', {
        labels: ['Yogurt', 'Kombucha Fresa', 'Kombucha Arándanos'],
        datasets: [{ data: [42, 33, 25], borderWidth: 0, backgroundColor: ['#6257df','#2aa873','#e6963c'] }]
      }, { cutout: '68%', plugins: { legend: { position: 'bottom' } }, scales: { x: { display: false }, y: { display: false } } });
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Abrir sección correcta si hay un hash en la URL al cargar
        if (window.location.hash) {
            const id = window.location.hash.substring(1);
            const targetBtn = document.querySelector(`.ap-nav__item[data-section="${id}"]`);
            if (targetBtn && document.getElementById(id)) {
                // Ejecutamos el clic para activar la sección
                targetBtn.click();
            }
        }

        const confirmForms  = document.querySelectorAll('form[data-confirm]');
        const modalOverlay  = document.getElementById('confirmModalOverlay');
        const modalMessage  = document.getElementById('confirmModalMessage');
        const modalCancel   = document.getElementById('confirmModalCancel');
        const modalAccept   = document.getElementById('confirmModalAccept');
        let formPendingSubmit = null;

        confirmForms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                formPendingSubmit = form;
                modalMessage.textContent = form.dataset.confirm;
                modalOverlay.classList.add('ap-modal-overlay--open');
            });
        });

        modalCancel?.addEventListener('click', () => {
            modalOverlay.classList.remove('ap-modal-overlay--open');
            formPendingSubmit = null;
        });

        modalAccept?.addEventListener('click', () => {
            if (formPendingSubmit) formPendingSubmit.submit();
        });

        modalOverlay?.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('ap-modal-overlay--open');
                formPendingSubmit = null;
            }
        });
    });
  </script>

  @stack('scripts')
</body>
</html>
