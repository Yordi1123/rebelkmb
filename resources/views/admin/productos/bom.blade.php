@extends('layouts.admin')

@section('title', 'BOM - ' . $producto->nombre)
@section('breadcrumb', 'Productos / Receta (BOM)')

@section('content')
<style>
    /* Estilos específicos para la vista de BOM tipo Pipeline */
    .bom-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 32px;
    }
    
    .bom-badge {
        background-color: #e0e7ff;
        color: #4338ca;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
    }

    .bom-pipeline {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 600px;
    }

    .bom-stage-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        width: 100%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        position: relative;
    }

    /* Colores por etapa para darle vida */
    .stage-Recepción { border-left: 4px solid #3b82f6; }
    .stage-Inoculación { border-left: 4px solid #10b981; }
    .stage-Mezcla { border-left: 4px solid #0ea5e9; }
    .stage-Desuerado { border-left: 4px solid #f43f5e; }
    .stage-Batido { border-left: 4px solid #f59e0b; }
    .stage-Envasado { border-left: 4px solid #8b5cf6; }
    .stage-default { border-left: 4px solid #6b7280; }

    .tipo-consumo { color: #dc2626; font-size: 11px; font-weight: bold; margin-right: 4px; }
    .tipo-subproducto { color: #16a34a; font-size: 11px; font-weight: bold; margin-right: 4px; }

    .bom-stage-header {
        padding: 12px 16px;
        border-bottom: 1px solid #f3f4f6;
    }

    .bom-stage-title {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .bom-stage-subtitle {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .bom-items-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .bom-item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid #f9fafb;
    }
    .bom-item-row:last-child {
        border-bottom: none;
    }

    .bom-item-info {
        display: flex;
        flex-direction: column;
    }
    
    .bom-item-name {
        font-weight: 500;
        color: #374151;
        font-size: 14px;
    }
    
    .bom-item-qty {
        font-size: 13px;
        color: #6b7280;
    }

    .bom-item-actions {
        display: flex;
        gap: 8px;
    }

    /* Flecha conectora entre tarjetas */
    .bom-connector {
        height: 24px;
        width: 1px;
        background-color: #d1d5db;
        margin: 8px 0;
        position: relative;
    }
    .bom-connector::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: -3px;
        width: 7px;
        height: 7px;
        border-right: 1px solid #d1d5db;
        border-bottom: 1px solid #d1d5db;
        transform: rotate(45deg);
    }

    .add-ingredient-card {
        background: #f9fafb;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        padding: 20px;
        width: 100%;
        max-width: 600px;
        text-align: center;
        margin-top: 24px;
    }
</style>

<div class="ap-page-heading">
    <div>
        <p class="ap-eyebrow">Receta / Bill of Materials</p>
        <div class="bom-header">
            <span class="bom-badge">{{ $producto->tipo->codigo ?? 'PRD' }}</span>
            <h1>{{ $producto->nombre }} ({{ $producto->presentacion }})</h1>
            @if ($producto->activo)
                <span class="ap-badge ap-status--green" style="margin-left:auto;">Activo</span>
            @else
                <span class="ap-badge ap-status--yellow" style="margin-left:auto;">Inactivo</span>
            @endif
        </div>
    </div>
    <a href="{{ route('admin.productos.index') }}" class="ap-btn ap-btn--secondary">
        Volver
    </a>
</div>

@if (session('success'))
    <div class="ap-panel" style="border-left: 4px solid #3aa76d; margin-bottom: 24px;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="ap-panel" style="border-left: 4px solid #d64545; margin-bottom: 24px; color: #d64545;">
        <ul style="margin:0; padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display: flex; gap: 40px; align-items: flex-start;">
    
    <!-- Lado Izquierdo: Pipeline Visual -->
    <div class="bom-pipeline">
        @forelse ($etapas as $nombreEtapa => $insumos)
            @php
                // Asignar clase de borde según nombre
                $borderClass = 'stage-default';
                if(str_contains($nombreEtapa, 'Recepción')) $borderClass = 'stage-Recepción';
                if(str_contains($nombreEtapa, 'Inoculación')) $borderClass = 'stage-Inoculación';
                if(str_contains($nombreEtapa, 'Mezcla')) $borderClass = 'stage-Mezcla';
                if(str_contains($nombreEtapa, 'Desuerado')) $borderClass = 'stage-Desuerado';
                if(str_contains($nombreEtapa, 'Batido') || str_contains($nombreEtapa, 'Frutado')) $borderClass = 'stage-Batido';
                if(str_contains($nombreEtapa, 'Envasado')) $borderClass = 'stage-Envasado';
            @endphp

            <div class="bom-stage-card {{ $borderClass }}">
                <div class="bom-stage-header">
                    <span class="bom-stage-subtitle">Etapa</span>
                    <h3 class="bom-stage-title">{{ $nombreEtapa }}</h3>
                </div>
                <ul class="bom-items-list">
                    @foreach ($insumos as $insumo)
                        <li class="bom-item-row">
                            <div class="bom-item-info">
                                <span class="bom-item-name">
                                    @if($insumo->pivot->tipo === 'subproducto')
                                        <span class="tipo-subproducto">⬆️ SALE:</span> 
                                    @else
                                        <span class="tipo-consumo">⬇️ ENTRA:</span> 
                                    @endif
                                    {{ $insumo->nombre }}
                                </span>
                                <span class="bom-item-qty">{{ number_format($insumo->pivot->cantidad_requerida, 4) }} {{ $insumo->pivot->unidad_medida }}</span>
                            </div>
                            <div class="bom-item-actions">
                                <form method="POST" action="{{ route('admin.productos.bom.destroy', [$producto, $insumo->pivot->id]) }}" onsubmit="return confirm('¿Quitar insumo de la receta?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ap-icon-btn" style="color: #9ca3af;" title="Eliminar">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if (!$loop->last)
                <div class="bom-connector"></div>
            @endif
        @empty
            <div class="ap-panel" style="text-align:center; color:#6b7280; width:100%;">
                <p>Este producto no tiene una receta definida aún.</p>
            </div>
        @endforelse

        <!-- Formulario para agregar insumo -->
        <div class="add-ingredient-card">
            <h4 style="margin-top:0; font-size:15px; color:#4b5563;">Añadir Insumo a la Receta</h4>
            <form action="{{ route('admin.productos.bom.store', $producto) }}" method="POST" style="display: flex; flex-direction: column; gap: 12px; text-align: left;">
                @csrf
                <div>
                    <label class="ap-label">Etapa de Producción</label>
                    <input type="text" name="etapa" class="ap-input" required placeholder="Ej: Recepción, Mezcla Inoculante..." list="etapas-list">
                    <datalist id="etapas-list">
                        <option value="Recepción">
                        <option value="Mezcla inoculante">
                        <option value="Inoculación">
                        <option value="Desuerado">
                        <option value="Preparación del conservante">
                        <option value="Adición del conservante">
                        <option value="Envasado">
                        <option value="Batido y Frutado">
                    </datalist>
                </div>
                <div>
                    <label class="ap-label">Dinámica de Inventario (Tipo)</label>
                    <div style="display: flex; gap: 16px; font-size: 14px; margin-top: 4px;">
                        <label><input type="radio" name="tipo" value="consumo" checked> ⬇️ Entra (Resta stock)</label>
                        <label><input type="radio" name="tipo" value="subproducto"> ⬆️ Sale (Genera stock)</label>
                    </div>
                </div>
                <div>
                    <label class="ap-label">Insumo / Material</label>
                    <select name="material_id" class="ap-input" required>
                        <option value="">-- Seleccionar Insumo --</option>
                        @foreach ($insumosDisponibles as $ins)
                            <option value="{{ $ins->id }}">{{ $ins->codigo }} - {{ $ins->nombre }} ({{ $ins->unidad_medida }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="ap-label">Cantidad Requerida</label>
                    <input type="number" step="0.0001" name="cantidad_requerida" class="ap-input" required placeholder="Ej: 1.5">
                </div>
                <button type="submit" class="ap-btn ap-btn--primary" style="width: 100%; justify-content: center;">
                    + Añadir a la Receta
                </button>
            </form>
        </div>
    </div>
    
    <!-- Lado Derecho: Resumen e Información -->
    <div style="flex: 1;">
        <div class="ap-panel">
            <h3 style="margin-top:0; font-size:16px;">Acerca de las Recetas (BOM)</h3>
            <p style="color:#6b7280; font-size:14px; line-height:1.5;">
                El Bill of Materials (BOM) define exactamente qué insumos se requieren para fabricar una unidad de este producto (<strong>1 {{ $producto->presentacion }}</strong>).
            </p>
            <p style="color:#6b7280; font-size:14px; line-height:1.5;">
                Agrupar los insumos por etapas de producción ayuda a planificar en qué momento del proceso se necesitarán los materiales desde el almacén.
            </p>
            
            <hr style="border:none; border-top:1px solid #e5e7eb; margin: 16px 0;">
            
            <h4 style="margin-top:0; font-size:14px;">Resumen</h4>
            <ul style="color:#4b5563; font-size:14px; padding-left:20px;">
                <li>Total Etapas: <strong>{{ count($etapas) }}</strong></li>
                <li>Total Insumos: <strong>{{ $producto->insumos->count() }}</strong></li>
            </ul>
        </div>
    </div>
</div>
@endsection
