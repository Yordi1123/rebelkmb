# Roadmap de Desarrollo: Rebel KMB — Módulos Pendientes

**Fecha:** 22 de Septiembre de 2026  
**Deadline estimado:** ~1 de Octubre de 2026  
**Rama activa:** `feature/recetas`  

---

## Módulos Completados ✅

| # | Módulo | Estado |
|---|--------|--------|
| — | Dashboard | ✅ Operativo |
| — | Usuarios (CRUD + Roles) | ✅ Operativo |
| — | Productos (+ Categorías, Tipos, Sabores) | ✅ Operativo |
| — | Proveedores | ✅ Operativo + Reglas de negocio |
| — | Insumos (+ Categorías de Insumo) | ✅ Operativo + Reglas de negocio |

---

## Módulos por Desarrollar (en orden de prioridad)

### Bloque 1 — Estructura Productiva (Base para todo lo demás)

| # | Módulo | Descripción | Horas est. |
|---|--------|-------------|:----------:|
| 1 | **BOM / Recetas** | Definir qué insumos y en qué cantidades componen cada producto. Con soporte de etapas. | 5-6h |

### Bloque 2 — Ciclo de Abastecimiento

| # | Módulo | Descripción | Horas est. |
|---|--------|-------------|:----------:|
| 2 | **Órdenes de Compra** | Registrar compras a proveedores y dar entrada de insumos al Kardex de materiales. | 3-4h |

### Bloque 3 — Ciclo de Producción

| # | Módulo | Descripción | Horas est. |
|---|--------|-------------|:----------:|
| 3 | **Órdenes de Producción** | Lanzar órdenes de fabricación que consuman insumos (según BOM) y generen producto terminado. | 5-6h |
| 4 | **Lotes / Trazabilidad** | Asignar lote a cada orden de producción. Registrar puntos críticos de control y pH. | 4-5h |
| 5 | **Producto Terminado + Kardex** | Ingreso del PT al almacén, control de stock de productos terminados. | 3-4h |

### Bloque 4 — Ciclo Comercial

| # | Módulo | Descripción | Horas est. |
|---|--------|-------------|:----------:|
| 6 | **Pedidos / Ventas** | Registro de pedidos de clientes con detalle de productos y cantidades. | 3-4h |
| 7 | **Despachos** | Registrar la salida de producto terminado hacia el cliente. Descuenta Kardex PT. | 2-3h |

### Bloque 5 — Planificación (MRP)

| # | Módulo | Descripción | Horas est. |
|---|--------|-------------|:----------:|
| 8 | **Pronósticos** | Proyección de demanda futura basada en datos históricos de ventas. | 2-3h |
| 9 | **MPS (Plan Maestro)** | Planificación maestra de producción: cuánto producir y cuándo. | 2-3h |
| 10 | **MRP (Requerimientos)** | Explosión de materiales: calcula qué insumos comprar y en qué fechas según el MPS y el BOM. | 3-4h |

### Bloque 6 — Consolidación

| # | Módulo | Descripción | Horas est. |
|---|--------|-------------|:----------:|
| 11 | **Reportes y Dashboard** | KPIs, gráficos de stock, producción, ventas. Enriquecer el dashboard existente. | 3-4h |

---

### Bloque 7 — Requerimiento Adicional (Pendiente de Negociación)

| # | Módulo | Descripción | Horas est. |
|---|--------|-------------|:----------:|
| 12 | **Valorización del Producto** | Cálculo del costo unitario de producción por producto basado en el costo de insumos del BOM. Requiere agregar `costo_unitario` a insumos y crear vistas de costeo. | 5-7h |

> ⚠️ **Nota:** Este módulo fue solicitado por el cliente como funcionalidad adicional al alcance original. Su implementación está sujeta a negociación comercial.

---

## Resumen de Esfuerzo

| Concepto | Horas |
|----------|:-----:|
| Módulos del sistema base (1-11) | **35-46h** |
| Requerimiento adicional (12) | **5-7h** |
| **Total general** | **40-53h** |

