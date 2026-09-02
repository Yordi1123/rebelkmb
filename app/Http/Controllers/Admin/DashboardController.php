<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Panel de administración principal.
     * Protegido por middleware 'auth' definido en web.php.
     * 
     * Consulta KPIs reales de la BD para mostrar en el dashboard.
     * Los conteos se irán llenando conforme se implementen los módulos.
     */
    public function index(): View
    {
        $kpis = [
            // Datos del usuario autenticadoS
            'usuario'           => auth()->user()->name,
            'rol'               => auth()->user()->rol,

            // Conteos reales de la BD (retornan 0 si no hay datos aún)
            'pedidos_activos'      => DB::table('pedidos')->count(),
            'ordenes_produccion'   => DB::table('ordenes_produccion')->count(),
            'lotes_activos'        => DB::table('lotes')->where('estado', 'vigente')->count(),
            'total_productos'      => DB::table('productos')->where('activo', true)->count(),
            'usuarios_activos'     => DB::table('users')->where('activo', true)->count(),

            // Meta: total de tablas en la BD actual (indicador de estado del sistema)
            'total_tablas' => count(DB::select('SHOW TABLES')),
        ];

        return view('admin.dashboard', compact('kpis'));
    }
}
