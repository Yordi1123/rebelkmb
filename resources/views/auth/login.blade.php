<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Acceso al sistema PlanFlow — Gestión de producción REBEL Kombucha">
  <title>Iniciar sesión — PlanFlow · Rebel Kombucha</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page">

  <div class="login-bubbles" id="loginBubbles" aria-hidden="true"></div>

  <div class="login-split">

    {{-- Panel izquierdo: identidad de marca --}}
    <aside class="login-brand" aria-hidden="true">
      <div class="login-brand__inner">
        <img src="{{ asset('images/rebel-logo.png') }}" alt="Rebel Kombucha" class="login-brand__logo">
        <div class="login-brand__divider"></div>
        <p class="login-brand__system">PlanFlow</p>
        <p class="login-brand__desc">
          Planifica la producción,<br>
          controla el inventario<br>
          y sigue cada lote<br>
          de principio a fin.
        </p>
      </div>
      <p class="login-brand__footer">© {{ date('Y') }} Rebel Kombucha</p>
    </aside>

    {{-- Panel derecho: formulario --}}
    <main class="login-form-panel">
      <div class="login-card" role="main">

        {{-- Cabecera del card --}}
        <div class="login-card__head">
          <h1 class="login-card__title">Bienvenido</h1>
          <p class="login-card__subtitle">Ingresa tus credenciales para acceder al sistema</p>
        </div>

        {{-- Alerta de errores de sesión --}}
        @if (session('status'))
          <div class="login-alert login-alert--info" role="alert">
            {{ session('status') }}
          </div>
        @endif

        {{-- Formulario --}}
        <form
          id="loginForm"
          method="POST"
          action="{{ route('login') }}"
          class="login-form"
          novalidate
        >
          @csrf

          {{-- Campo: correo --}}
          <div class="form-group @error('email') form-group--error @enderror">
            <label for="email" class="form-label">Correo electrónico</label>
            <div class="form-input-wrap">
              <span class="form-icon" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="4" width="20" height="16" rx="2"/>
                  <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
              </span>
              <input
                id="email"
                type="email"
                name="email"
                class="form-input"
                value="{{ old('email') }}"
                placeholder="usuario@rebelkmb.com"
                autocomplete="username"
                autofocus
                required
              >
            </div>
            @error('email')
              <p class="form-error" role="alert">{{ $message }}</p>
            @enderror
          </div>

          {{-- Campo: contraseña --}}
          <div class="form-group @error('password') form-group--error @enderror">
            <div class="form-label-row">
              <label for="password" class="form-label">Contraseña</label>
            </div>
            <div class="form-input-wrap">
              <span class="form-icon" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </span>
              <input
                id="password"
                type="password"
                name="password"
                class="form-input"
                placeholder="••••••••"
                autocomplete="current-password"
                required
              >
              <button
                type="button"
                class="form-toggle-pw"
                id="togglePassword"
                aria-label="Mostrar contraseña"
                title="Mostrar / ocultar contraseña"
              >
                <svg id="eyeOpen" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                <svg id="eyeClosed" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                  <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                  <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                  <line x1="1" y1="1" x2="23" y2="23"/>
                </svg>
              </button>
            </div>
            @error('password')
              <p class="form-error" role="alert">{{ $message }}</p>
            @enderror
          </div>

          {{-- Recordarme --}}
          <div class="form-group form-group--check">
            <label class="form-check-label" for="remember">
              <input id="remember" type="checkbox" name="remember" class="form-check">
              <span>Mantener sesión iniciada</span>
            </label>
          </div>

          {{-- Botón de submit --}}
          <button
            id="submitBtn"
            type="submit"
            class="login-btn"
          >
            <span class="login-btn__text">Ingresar al sistema</span>
            <span class="login-btn__arrow" aria-hidden="true">→</span>
          </button>

        </form>

        {{-- Volver al inicio --}}
        <div class="login-back">
          <a href="{{ route('home') }}" class="login-back__link">
            ← Volver al inicio
          </a>
        </div>

      </div>
    </main>

  </div>

  <script>
    // Toggle mostrar/ocultar contraseña
    const toggleBtn = document.getElementById('togglePassword');
    const pwInput   = document.getElementById('password');
    const eyeOpen   = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    toggleBtn.addEventListener('click', () => {
      const isHidden = pwInput.type === 'password';
      pwInput.type   = isHidden ? 'text' : 'password';
      eyeOpen.style.display   = isHidden ? 'none'  : '';
      eyeClosed.style.display = isHidden ? ''      : 'none';
      toggleBtn.setAttribute('aria-label', isHidden ? 'Ocultar contraseña' : 'Mostrar contraseña');
    });

    // Animación de burbujas (igual al homepage)
    (function () {
      const container = document.getElementById('loginBubbles');
      const count = 12;
      for (let i = 0; i < count; i++) {
        const b = document.createElement('div');
        b.className = 'bubble';
        const size = 10 + Math.random() * 28;
        b.style.cssText = [
          `width:${size}px`,
          `height:${size}px`,
          `left:${Math.random() * 100}%`,
          `animation-duration:${9 + Math.random() * 14}s`,
          `animation-delay:${Math.random() * 8}s`,
        ].join(';');
        container.appendChild(b);
      }
    })();
  </script>

</body>
</html>
