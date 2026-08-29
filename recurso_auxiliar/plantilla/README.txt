# PlanFlow ERP — Prototipo web

Prototipo frontend para un sistema de planificación y control de producción basado en:

PEDIDOS/DEMANDA → PRONÓSTICO → MPS → MRP → COMPRAS → INVENTARIO MP → PRODUCCIÓN → LOTES/TRAZABILIDAD → PRODUCTO TERMINADO → DESPACHO

## Incluye

- Dashboard ejecutivo con KPIs.
- Gráficos de demanda vs. pronóstico.
- Inventario por categoría.
- Flujo visual de planificación.
- Alertas operativas.
- Pedidos / Ventas.
- Pronósticos con parámetros de período, método y α.
- MPS.
- MRP.
- Inventarios.
- Compras y proveedores.
- Producción.
- Lotes y trazabilidad.
- Producto terminado y despachos.
- Reportes.
- Diseño responsive para PC y celular.
- Datos simulados para demostración.

## Ejecutar

No necesita servidor para la primera demostración.

1. Descomprimir el ZIP.
2. Abrir `index.html` en Chrome o Edge.

Chart.js se carga desde CDN, por lo que se requiere Internet para visualizar los gráficos.

## Siguiente etapa

Para convertirlo en sistema real se puede conectar a un backend (por ejemplo Python + FastAPI) y una base de datos, agregando autenticación, CRUD, MPS/MRP real, proveedores, compras, inventarios, trazabilidad, reportes PDF y auditoría.
