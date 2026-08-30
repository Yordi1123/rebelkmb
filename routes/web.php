<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\TipoController;
use App\Http\Controllers\Admin\SaborController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:6,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas — Panel de Administración
| Middleware 'auth' redirige a /login si no está autenticado
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
         ->name('dashboard');
    Route::resource('/productos', ProductoController::class);
    Route::resource('/categorias', CategoriaController::class)->except('show');
    Route::resource('/tipos', TipoController::class)->except('show');
    Route::resource('/sabores', SaborController::class)->except('show');
});