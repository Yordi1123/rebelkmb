<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PlanFlow — Rebel Kombucha</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="home">

  <div class="bubbles" id="bubbles" aria-hidden="true"></div>

  <main class="content">
    <div class="brand">
      <img src="{{ asset('images/rebel-logo.png') }}" alt="Rebel Kombucha" class="logo-img">
      <p class="brand-sub">Sistema interno</p>
    </div>

    <div class="divider"></div>

    <h1 class="system-name">PlanFlow</h1>
    <p class="tagline">
      Planifica la producción, controla el inventario<br>
      y sigue cada lote de principio a fin.
    </p>

    {{-- TODO: cambiar a route('login') cuando esa ruta con nombre exista tras el merge con la rama 'login' --}}
    <a href="/login" class="cta">
      Iniciar sesión
      <span class="cta-arrow" aria-hidden="true">→</span>
    </a>
  </main>

  <footer>© {{ date('Y') }} Rebel Kombucha — PlanFlow</footer>

</body>
</html>
