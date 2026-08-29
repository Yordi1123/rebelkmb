<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Panel de administración principal.
     * Protegido por middleware 'auth' en web.php.
     * 
     * En esta iteración se muestran KPIs básicos de la BD.
     * Los módulos completos (lotes, MPS, MRP) se implementan en ramas futuras.
     */
    public function index(): View
    {
        // KPIs básicos — se expandirán conforme se implementen los módulos
        $kpis = [
            'usuario' => auth()->user()->name,
            'rol'     => auth()->user()->rol,
        ];

        return view('admin.dashboard', compact('kpis'));
    }
}
