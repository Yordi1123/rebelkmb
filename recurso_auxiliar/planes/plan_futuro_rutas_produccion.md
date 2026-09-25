# Especificaciones Futuras: Módulo de Rutas de Producción (Routing)

## Contexto y Justificación
Durante el desarrollo de la Fase 1 del sistema, se implementó el módulo **BOM (Bill of Materials)** enfocado exclusivamente en la lista de materiales físicos necesarios para manufacturar los productos. Esto fue suficiente para habilitar el Kardex, Compras y MRP.

Sin embargo, para reflejar fielmente los **Diagramas de Operaciones de Proceso (DOP)** —los cuales incluyen tiempos, temperaturas, inspecciones y subproductos (como el Desuerado en el Yogurt Griego)— se requiere implementar el módulo de **Rutas de Producción (Routing)** en una futura Fase 2.

---

## 1. Arquitectura de Datos Propuesta

Para este módulo se deberán crear las siguientes entidades base:

### A. Centros de Trabajo (Work Centers)
Representan las ubicaciones o maquinarias físicas donde ocurre la operación.
- `id`
- `nombre` (Ej: Marmita Pasteurizadora, Cuarto Frío, Área de Envasado)
- `costo_por_hora` (Para cálculo de costos de fabricación)
- `capacidad_maxima` (Ej: 100 Litros)

### B. Catálogo de Operaciones
Las acciones estandarizadas que se realizan en la planta.
- `id`
- `nombre` (Ej: Pasteurizado, Filtrado, Desuerado)
- `tipo` (Operación, Inspección, Combinado, Transporte, Espera)

### C. Rutas de Producción (Routings)
La "receta maestra" de cómo se hace un producto.
- `id`
- `nombre` (Ej: Ruta Estándar Yogurt Griego)
- `producto_id` (Relación opcional, si la ruta es exclusiva de un producto)

### D. Detalles de Ruta (Routing Steps)
La secuencia de pasos que unen las Operaciones y los Centros de Trabajo.
- `ruta_id`
- `operacion_id`
- `centro_trabajo_id`
- `orden` (Secuencia: 1, 2, 3...)
- `tiempo_estimado_minutos`
- `temperatura_requerida_celsius`
- `es_punto_critico` (Booleano para calidad)

---

## 2. Integración con el Módulo BOM Actual

El diseño propuesto sigue el **estándar ERP de industria**, separando Materiales de Operaciones. La integración ocurrirá al momento de crear una **Orden de Producción**.

1. **El BOM** aportará los ingredientes a descontar del almacén.
2. **La Ruta** dictará en qué momento específico (Paso 1, Paso 3) entra cada ingrediente. 
   *(Ej: El BOM dice que se necesitan 10g de Cultivo. La Ruta dirá que el Cultivo se agrega en el "Paso 5: Inoculación").*

---

## 3. Funcionalidades Clave (Features)

- **Cálculo de Tiempos de Fabricación (Lead Time):** Al sumar el `tiempo_estimado` de cada paso, el sistema podrá calcular exactamente cuántas horas/días toma fabricar un lote, permitiendo agendar la producción en un calendario.
- **Costeo de Fabricación (Overhead):** El sistema podrá multiplicar los tiempos de la ruta por el `costo_por_hora` de los centros de trabajo, añadiendo el "costo de fabricación" al costo base de los materiales del BOM.
- **Trazabilidad de Subproductos:** En la Ruta se podrá especificar que el paso "Desuerado" genera un ingreso automático de stock al insumo "Suero de leche".
- **Checklists de Calidad (HACCP):** Los pasos marcados como `es_punto_critico` obligarán al operario a registrar en el sistema la temperatura y pH real antes de dejarle avanzar al siguiente paso.

---

## 4. Consideraciones para la Implementación
- El módulo BOM actual **no sufrirá alteraciones destructivas**, solo se le añadirá una llave foránea (`routing_step_id`) para saber a qué paso de la ruta corresponde cada material.
- La interfaz de usuario deberá ser muy visual (estilo Kanban o Pipeline) para que los operarios puedan hacer "Drag & Drop" o avanzar las Órdenes de Producción paso a paso a través de la Ruta.
