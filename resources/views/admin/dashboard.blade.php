<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — PlanFlow · Rebel Kombucha</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="
  background: #F2EEE5;
  font-family: 'Work Sans', sans-serif;
  display: flex; align-items: center; justify-content: center;
  min-height: 100vh; margin: 0;
  color: #2B2620;
">
  <div style="text-align:center; max-width:560px; padding:40px 24px;">
    <img src="{{ asset('images/rebel-logo.png') }}" alt="Rebel Kombucha" style="width:200px; margin-bottom:32px;">
    <h1 style="font-family:'Fraunces',serif; font-weight:500; font-size:1.75rem; margin-bottom:12px; letter-spacing:-0.01em;">
      ¡Bienvenido, {{ $kpis['usuario'] }}!
    </h1>
    <p style="color:#6B6355; font-size:0.95rem; margin-bottom:8px;">
      Rol: <strong style="color:#96601A; text-transform:capitalize;">{{ $kpis['rol'] }}</strong>
    </p>
    <p style="color:#6B6355; font-size:0.88rem; margin-bottom:40px; line-height:1.6;">
      El panel de administración completo se implementará en el Paso 3.<br>
      Este mensaje confirma que el login funciona correctamente. ✅
    </p>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" style="
        background:#2B2620; color:#fff; border:none; padding:13px 36px;
        font-family:'Work Sans',sans-serif; font-size:0.93rem; font-weight:500;
        border-radius:2px; cursor:pointer; letter-spacing:0.02em;
      ">
        Cerrar sesión
      </button>
    </form>
  </div>
</body>
</html>
