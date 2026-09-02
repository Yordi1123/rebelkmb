# Plan de Desarrollo: Módulos de Operaciones Core (Insumos y BOM)

Este documento establece la arquitectura y el roadmap de desarrollo para los siguientes módulos críticos del ERP REBEL Kombucha, tras haber finalizado exitosamente el Catálogo de Productos Terminados.

## Módulo 1: Gestión de Materias Primas e Insumos

Antes de poder crear una receta, el sistema necesita conocer qué materiales existen en la planta, desde la fruta y el azúcar hasta las botellas y etiquetas.

### Modelo de Datos (`insumos`)
Se creará una tabla independiente a los productos terminados para mantener la base de datos limpia y enfocada.
* `id`
* `codigo` (Ej. MP-FRU-001)
* `nombre` (Ej. Fresa congelada, Botella vidrio 330ml)
* `categoria` (Enum: Materia Prima, Empaque, Insumo Químico, Cultivo Lácteo)
* `unidad_medida` (kg, L, unidad, gr)
* `stock_minimo` (Para alertas futuras en el Dashboard)
* `activo` (Boolean)

### Interfaz de Usuario (UI)
* CRUD estándar (similar al de productos) pero más simplificado.
* Filtros por categoría de insumo (Materias primas vs Empaques).

---

## Módulo 2: Lista de Materiales (BOM) / Recetas (DOP)

Este es el módulo maestro que conecta el *Catálogo de Productos* con el *Catálogo de Insumos*. Define "cómo se hace" un producto.

### Modelo de Datos Principal (`recetas`)
* `id`
* `producto_id` (Relación: 1 Producto tiene 1 o muchas Recetas, ej. para 1L de Kombucha Fresa)
* `codigo_dop` (Ej. DOP-KBF-001, según el documento de lógica de negocio)
* `volumen_base` (Ej. "Para fabricar 100 Litros")
* `rendimiento_esperado` (Porcentaje de eficiencia esperado)
* `activa` (Permite tener un historial de recetas, pero solo una activa para producción)

### Modelo de Datos Detalle (`receta_insumo` - Pivot)
* `id`
* `receta_id`
* `insumo_id`
* `cantidad` (La cantidad exacta requerida del insumo para el `volumen_base`)
* `merma_porcentaje` (Tolerancia de pérdida en el proceso)

### Interfaz de Usuario (UI)
* **Maestro-Detalle:** Una interfaz avanzada donde el usuario selecciona el Producto Terminado, y debajo tiene una tabla dinámica (estilo Excel o formulario de facturación) donde puede ir agregando insumos, ajustando cantidades dinámicamente y guardando la receta completa.

---

## Módulo 3 (Futuro): Compras / Ingresos a Kardex

Una vez que existan los insumos, se habilitará el módulo donde almacén registra las facturas y guías de remisión, alimentando automáticamente el stock de las Materias Primas.

---

> [!IMPORTANT]
> **Decisiones Arquitectónicas**
> * Se separan los Insumos de los Productos Terminados para evitar tablas híbridas confusas. Los Productos son para **Venta/Producción**, los Insumos son para **Compra/Gasto**.
> * La relación BOM permitirá escalar al módulo de **MRP** en el futuro (si me piden producir 500 botellas, el sistema multiplicará la receta x 500 y me dirá exactamente cuántos Kg de azúcar debo sacar del almacén).

## Flujo de Trabajo (Git) sugerido

1. Realizar PR (Pull Request) de la rama actual `CRUDproductos` hacia `develop`.
2. Eliminar la rama local y remota de `CRUDproductos`.
3. Desde `develop` actualizado, crear la nueva rama: `git checkout -b feature/insumos-bom`.
4. Iniciar el desarrollo siguiendo este documento.
