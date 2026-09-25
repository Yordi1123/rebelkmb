# Resultado de Implementación: Módulo BOM (Bill of Materials)

**Fecha:** 25/09/2026  
**Versión:** 1.1 (con Subproductos)  
**Estado:** ✅ COMPLETADO

---

## Resumen Ejecutivo

Se implementó exitosamente el módulo de **Recetas (BOM - Bill of Materials)** para el sistema RebelKmb. El módulo permite definir, visualizar y gestionar los insumos necesarios para fabricar cada producto (Yogurt Griego, Yogurt Griego Frutado y Yogurt Frutado), agrupando los materiales por etapa del proceso productivo y diferenciando entre insumos que se consumen y subproductos que se generan durante la fabricación.

---

## Componentes Desarrollados

### 1. Base de Datos (Migraciones)

| Migración | Descripción |
|-----------|-------------|
| `add_etapa_to_bom_table` | Agrega el campo `etapa` (string) a la tabla pivot `bom`. Permite agrupar los materiales por fase del proceso. |
| `add_tipo_to_bom_table` | Agrega el campo `tipo` (enum: `consumo`, `subproducto`) a la tabla `bom`. Permite distinguir si el material se resta o se suma al inventario. |

**Estructura final de la tabla `bom`:**

```
id | producto_id | material_id | cantidad_requerida | unidad_medida | etapa | tipo | timestamps
```

**Restricción única:** `producto_id + material_id` (evita duplicados de insumo en la misma receta, garantizando integridad de datos).

---

### 2. Seeders (Datos de Prueba)

#### `InsumoSeeder` — Insumos agregados o modificados

| Código | Nombre | Categoría | Proveedor |
|--------|--------|-----------|-----------|
| `LECHE-UHT` | Leche UHT | Materia Prima Líquida | Lácteos del Sur SAC |
| `YG-BASE` | Yogurt Griego Base | Materia Prima Líquida | Sin proveedor (fabricación interna) |
| `SUERO` | Suero de Leche | Materia Prima Líquida | Sin proveedor (subproducto del proceso) |
| `NATAM` | Natamicina | Aditivos y Conservantes | Cultivos Biológicos S.A. |
| `MERM-FRE` | Mermelada de Fresa | Frutas y Saborizantes | Agro Frutas EIRL |
| `MERM-ARA` | Mermelada de Arándanos | Frutas y Saborizantes | Agro Frutas EIRL |
| `MERM-MAR` | Mermelada de Maracuyá | Frutas y Saborizantes | Agro Frutas EIRL |
| `MERM-MAN` | Mermelada de Mango | Frutas y Saborizantes | Agro Frutas EIRL |
| `MERM-MM` | Mermelada Maracuyá-Mango | Frutas y Saborizantes | Agro Frutas EIRL |
| `ENV150` | Envase Yogurt 150ml | Envases y Empaques | Cristalerías del Perú |
| `ENV1L` | Envase Yogurt 1L | Envases y Empaques | Cristalerías del Perú |
| `ETIQ` | Etiquetas | Envases y Empaques | Cristalerías del Perú |

#### `BomSeeder` — Recetas implementadas

**Yogurt Griego (YG) · Presentación: 1L**

| Etapa | Material | Cantidad | Tipo |
|-------|----------|----------|------|
| Recepción | Leche | 1.5 Litros | Consumo |
| Mezcla inoculante | Leche UHT | 0.05 Litros | Consumo |
| Mezcla inoculante | Cultivo Yogurt | 10 Gramos | Consumo |
| Desuerado | Suero de Leche | 0.5 Litros | **Subproducto** |
| Preparación del conservante | Suero de Leche | 0.1 Litros | Consumo |
| Preparación del conservante | Natamicina | 0.5 Gramos | Consumo |
| Envasado | Envase 1L | 1 Unidad | Consumo |
| Envasado | Chapas/Tapas | 1 Unidad | Consumo |
| Envasado | Etiquetas | 1 Unidad | Consumo |

**Yogurt Griego Frutado (YGF) · Presentación: 150ml** *(por sabor: Fresa, Arándanos, Maracuyá-Mango)*

| Etapa | Material | Cantidad | Tipo |
|-------|----------|----------|------|
| Envasado | Yogurt Griego Base | 135 Gramos | Consumo |
| Envasado | Envase 150ml | 1 Unidad | Consumo |
| Envasado | Chapas/Tapas | 1 Unidad | Consumo |
| Envasado | Etiquetas | 1 Unidad | Consumo |
| Batido y Frutado | Mermelada `<sabor>` | 15 Gramos | Consumo |

> **Nota arquitectónica:** El YGF usa un BOM de 2 niveles. El "Yogurt Griego Base" es en sí mismo un insumo fabricado internamente (cuya producción se rige por la receta del YG). Esto refleja la realidad del DOP donde primero se produce la base y luego se porciona en envases individuales con la mermelada.

**Yogurt Frutado (YF) · Presentación: 1L** *(por sabor: Fresa, Arándanos, Maracuyá, Mango)*

| Etapa | Material | Cantidad | Tipo |
|-------|----------|----------|------|
| Recepción | Leche | 0.9 Litros | Consumo |
| Mezcla inoculante | Leche UHT | 0.05 Litros | Consumo |
| Mezcla inoculante | Cultivo Yogurt | 10 Gramos | Consumo |
| Preparación del conservante | Suero de Leche | 0.1 Litros | Consumo |
| Preparación del conservante | Natamicina | 0.5 Gramos | Consumo |
| Batido y Frutado | Mermelada `<sabor>` | 100 Gramos | Consumo |
| Envasado | Envase 1L | 1 Unidad | Consumo |
| Envasado | Chapas/Tapas | 1 Unidad | Consumo |
| Envasado | Etiquetas | 1 Unidad | Consumo |

---

### 3. Modelos y Relaciones

**`Producto.php`**
```php
public function insumos(): BelongsToMany
{
    return $this->belongsToMany(Insumo::class, 'bom', 'producto_id', 'material_id')
                ->withPivot('id', 'cantidad_requerida', 'unidad_medida', 'etapa', 'tipo')
                ->withTimestamps();
}
```

**`Insumo.php`**
```php
public function productos(): BelongsToMany
{
    return $this->belongsToMany(Producto::class, 'bom', 'material_id', 'producto_id')
                ->withPivot('id', 'cantidad_requerida', 'unidad_medida', 'etapa', 'tipo')
                ->withTimestamps();
}
```

---

### 4. Controlador (`BomController.php`)

Ubicación: `app/Http/Controllers/Admin/BomController.php`

| Método | Ruta | Descripción |
|--------|------|-------------|
| `index(Producto)` | GET `/admin/productos/{producto}/bom` | Carga los insumos agrupados por etapa y lista los disponibles para agregar. |
| `store(Request, Producto)` | POST `/admin/productos/{producto}/bom` | Valida y agrega un nuevo insumo a la receta con su etapa y tipo. |
| `update(Request, Producto, $bomId)` | PUT `/admin/productos/{producto}/bom/{id}` | Actualiza cantidad, etapa y tipo de un ítem de la receta. |
| `destroy(Producto, $bomId)` | DELETE `/admin/productos/{producto}/bom/{id}` | Elimina un insumo de la receta. |

---

### 5. Rutas (Anidadas en `web.php`)

```php
Route::resource('productos.bom', BomController::class)
     ->only(['index', 'store', 'update', 'destroy'])
     ->shallow();
```

Rutas nombradas generadas: `admin.productos.bom.index`, `admin.productos.bom.store`, `admin.productos.bom.update`, `admin.productos.bom.destroy`.

---

### 6. Interfaz de Usuario

**Catálogo de Productos (`admin.productos.index`)**
- Se agregó botón de acceso rápido a la Receta (BOM) por cada producto, con ícono de documento y color ámbar para diferenciarlo de las acciones de Editar y Eliminar.

**Vista Receta BOM (`admin.productos.bom`)**
- Diseño de **Pipeline Vertical** con tarjetas por etapa conectadas por flechas secuenciales.
- Código de colores por etapa:
  - 🔵 Azul → Recepción
  - 🔵 Celeste → Mezcla inoculante
  - 🟢 Verde → Inoculación
  - 🔴 Rojo rosa → Desuerado
  - 🟡 Amarillo → Batido y Frutado
  - 🟣 Morado → Envasado
- Indicadores de dinámica de inventario por fila:
  - ⬇️ **ENTRA** (rojo) → Material que se descuenta del almacén (consumo).
  - ⬆️ **SALE** (verde) → Material que se genera en el proceso (subproducto). Ej: Suero de Leche en el Desuerado.
- Formulario integrado para agregar nuevos insumos con:
  - Autocompletado de etapas (todas las del DOP de yogurt).
  - Radio button de "Dinámica de Inventario" (Consumo / Subproducto).
  - Selector de insumo disponible (sin mostrar los que ya están en la receta).
- Panel lateral con resumen (total etapas, total insumos).

---

## Decisiones Arquitectónicas Documentadas

1. **BOM por unidad vendible, no por lote:** Todas las cantidades son por 1 unidad del producto terminado (1 botella, 1 envase). El cálculo por lote lo realizará el MRP automáticamente al multiplicar por la cantidad de la Orden de Producción.
2. **Mermeladas = Compra a proveedor:** Confirmado por el usuario. Las mermeladas (Fresa, Arándanos, Maracuyá, Mango, Maracuyá-Mango) se adquieren ya procesadas, no se fabrican internamente.
3. **Suero de Leche = Subproducto del proceso:** No se compra. Se genera durante el Desuerado y se reutiliza en la preparación del conservante (suero + Natamicina al 0.2%).
4. **BOM de 2 niveles para YGF:** El Yogurt Griego Frutado (150ml) usa como insumo el "Yogurt Griego Base", que a su vez tiene su propia receta. Esto simplifica la planificación y es el enfoque estándar en ERPs.

---

## Pendiente (Fase 2)

Ver: [`plan_futuro_rutas_produccion.md`](./plan_futuro_rutas_produccion.md)

El módulo de **Rutas de Producción (Routing)** —que capturará los tiempos de proceso, temperaturas, centros de trabajo y checklists de calidad HACCP— está documentado para una Fase 2 posterior a la entrega inicial del sistema.
