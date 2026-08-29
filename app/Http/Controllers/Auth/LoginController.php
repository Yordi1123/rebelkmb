<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     * Si el usuario ya está autenticado, redirige al dashboard.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Procesa el intento de login con seguridad de producción:
     * - Rate limiting (máx. 6 intentos por minuto por IP+email)
     * - Verificación de campo 'activo' post-autenticación
     * - Regeneración del ID de sesión (previene session fixation)
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Validación de entradas
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // 2. Rate limiting: bloquea tras 6 intentos fallidos por minuto
        $this->ensureIsNotRateLimited($request);

        // 3. Intento de autenticación
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            // Registrar el fallo para el rate limiter
            RateLimiter::hit($this->throttleKey($request), 60);

            throw ValidationException::withMessages([
                'email' => 'Las credenciales ingresadas no coinciden con nuestros registros.',
            ]);
        }

        // 4. Verificar que el usuario esté activo (sin revelar si el email existe)
        if (! Auth::user()->activo) {
            Auth::logout();
            $request->session()->invalidate();

            throw ValidationException::withMessages([
                'email' => 'Tu cuenta ha sido desactivada. Contacta al administrador.',
            ]);
        }

        // 5. Limpiar el rate limiter al login exitoso
        RateLimiter::clear($this->throttleKey($request));

        // 6. Regenerar el ID de sesión (previene session fixation attack)
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Cierra la sesión de forma segura:
     * - Destruye la sesión completa
     * - Regenera el token CSRF
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Verifica si el usuario excedió el límite de intentos.
     * Clave única: email + IP para mayor precisión.
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 6)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => "Demasiados intentos de acceso. Intenta nuevamente en {$seconds} segundos.",
        ]);
    }

    /**
     * Genera la clave única para el rate limiter.
     * Combina email (lowercase) + IP para evitar abuso por diccionario.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}
