# Roadmap del ERP: Fases de Desarrollo Lógico

Para construir el ERP industrial (MRP) de REBEL Kombucha de forma escalable y asegurar la automatización del Kardex y la trazabilidad de la producción, el desarrollo debe seguir estrictamente este orden lógico de fases:

## Fase 1: Catálogo de Productos Terminados (COMPLETADO 🎉)
* **Objetivo:** Definir qué vendemos y producimos (Yogures, Kombuchas, Sabores).
* **Descripción:** Es la base de datos maestra de los SKU (Stock Keeping Units) finales de la empresa. Todo lote de producción nacerá a partir de uno de estos registros.

## Fase 2: Gestión de Materias Primas e Insumos (PRÓXIMO PASO)
* **Objetivo:** Definir qué compramos.
* **Descripción:** Un módulo para registrar todo el catálogo de insumos que la planta adquiere: ingredientes (azúcar, fruta, cultivos lácteos), empaques (botellas, tapas, cajas) e insumos químicos de limpieza. Esto permite estandarizar las compras.

## Fase 3: Lista de Materiales (BOM) y Recetas
* **Objetivo:** Conectar la Fase 1 con la Fase 2. Definir "cómo se hace" un producto.
* **Descripción:** Aquí se configuran las fórmulas maestras. Por ejemplo: *Para fabricar 1 Litro de Kombucha Fresa se requieren 1L de Base, 50g de puré de fresa y 1 Botella de vidrio*. Esto es vital para el cálculo de costos y la descarga automática de inventarios.

## Fase 4: Módulo de Compras y Kardex de Insumos
* **Objetivo:** Alimentar el inventario real (entradas).
* **Descripción:** Módulo donde el responsable de almacén registra las guías de remisión y facturas de los proveedores. Aquí el "Catálogo de Insumos" cobra vida al tener cantidades físicas reales almacenadas.

## Fase 5: Control de Lotes de Producción (EL NÚCLEO)
* **Objetivo:** El día a día de la planta, digitalización de los procesos de calidad (HACCP) y automatización del inventario.
* **Descripción:** El operario inicia un "Nuevo Lote" seleccionando un Producto (Fase 1). El sistema carga su Receta (Fase 3), valida que exista suficiente stock en Almacén (Fase 4) y bloquea dichos insumos. Durante la producción se registran variables críticas (pH, temperatura, mermas). Al aprobar el lote, el sistema descuenta definitivamente los insumos del Kardex e ingresa el producto terminado al inventario de ventas.

---

> [!NOTE] 
> **Contexto para Desarrolladores:**
> Es imperativo no saltarse a la Fase 5 (Control de Lotes) antes de completar las fases previas. Hacerlo forzaría el uso de "texto libre" para los ingredientes, rompiendo la trazabilidad, la estandarización y haciendo imposible la automatización del Kardex.
