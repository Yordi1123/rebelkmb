# Análisis Actualizado: Módulo BOM (con DOP-YF-01 y Tabla de Materiales)

## Descubrimientos Críticos

### 🔴 Hallazgo #1: BOM Multinivel (Producto como Insumo)
La tabla de materiales revela que el **Yogurt Griego Frutado (YGF)** usa como ingrediente principal el **"Yogurt Griego Base (135g)"**, que a su vez es otro producto terminado (YG). 

Esto significa que tenemos un **BOM de 2 niveles**:
```
Yogurt Griego Frutado 150ml (YGF)
├── Yogurt Griego Base ........... 135g  ← ¡Esto es OTRO producto (YG)!
├── Mermelada <sabor> ............ 15g
├── Envase ....................... 1 unidad
├── Chapa ........................ 1 unidad
└── Etiqueta ..................... 1 unidad
```

**Implicación para la BD:** La tabla `bom` actual solo referencia `material_id` (insumos). Necesitamos poder referenciar también un `producto_id` como ingrediente, O registrar el "Yogurt Griego Base" como un **insumo de fabricación interna** (sin proveedor) en la tabla `materiales`.

> **Mi recomendación:** Registrar "Yogurt Griego Base" como un insumo interno (como ya hacemos con "Kombucha Madre"), ya que simplifica enormemente la arquitectura. El MRP luego se encargará de "explotar" esa demanda hacia los insumos del nivel inferior.

### 🔴 Hallazgo #2: Mermelada como insumo variable por sabor
La tabla muestra `Mermelada <sabor>` como un placeholder. En el BOM, la mermelada cambia según el sabor del producto:
- YGF Fresa → Mermelada Fresa (15g)
- YGF Arándanos → Mermelada Arándanos (15g)
- YF Fresa → Mermelada Fresa (100g)

**Implicación:** Las mermeladas deben registrarse como insumos independientes en el catálogo (ej: `MERM-FRE`, `MERM-ARA`). El BOM de cada producto con sabor específico referenciará su mermelada correspondiente.

### 🟡 Hallazgo #3: Insumos que faltan en el catálogo actual
Comparando la tabla de materiales con nuestro `InsumoSeeder`, faltan:

| Insumo | Código sugerido | Categoría |
|--------|----------------|-----------|
| Etiquetas | `ETIQ` | Envases y Empaques |
| Envase 1L (Yogurt) | `ENV1L` | Envases y Empaques |
| Yogurt Griego Base | `YG-BASE` | *Nuevo: Productos Intermedios* |
| Mermelada Fresa | `MERM-FRE` | Frutas y Saborizantes |
| Mermelada Arándanos | `MERM-ARA` | Frutas y Saborizantes |
| Mermelada Maracuyá | `MERM-MAR` | Frutas y Saborizantes |
| Mermelada Mango | `MERM-MAN` | Frutas y Saborizantes |
| Mermelada Maracuyá-Mango | `MERM-MM` | Frutas y Saborizantes |

### 🟢 Hallazgo #4: El BOM se define por unidad de producto terminado
Las cantidades de la tabla son **por unidad vendible** (1 botella, 1 envase), no por lote de producción. Esto es perfecto para el MRP: si necesitas 100 unidades de YG, el sistema calculará 100 × 1.5L = 150L de leche.

---

## DOP del Yogurt Frutado: Flujo de 3 Líneas Paralelas

El DOP-YF-01 muestra un proceso con **3 líneas de entrada** que convergen:

```
LÍNEA LECHE                LÍNEA CULTIVO               LÍNEA SUERO
    │                          │                           │
 1. Recepción               2. Recepción               (subproducto)
    │                          │                           │
 1. Filtrado              1. Mezcla inoculante             │
    │                    (+ Leche UHT, 20min 2°C)          │
 2. Pasteurizado              │                            │
    (80°C, 15')          2. Conservación                   │
    │                      congelada                       │
 3. Enfriamiento                                    4. Preparación
    (43°C)                     │                      conservante
    │                          │                   (suero + natamicina
 3. Inoculado ◄────────────────┘                       0.2%)
    │                                                      │
 5. Incubación (6h)                                        │
    │                                                      │
 7. Adición del conservante al 0.2% ◄─────────────────────┘
    │
 8. Batido y Frutado  ◄──── (aquí entra la Mermelada <sabor>)
    │
 9. Envasado  ◄──── Envases esterilizados
    │
    Transporte → Almacenamiento en frío (2°C) → FIN
```

**Resumen de actividades:** 9 Operaciones, 2 Inspecciones, 3 Combinados, 1 Almacenado, 1 Transporte = **16 actividades totales**

---

## Plan de Implementación Definitivo del BOM

### Cambios en Base de Datos
#### [NEW] Migración `add_etapa_to_bom_table`
- Añadir campo `etapa` (string, nullable) a la tabla `bom`.
- Añadir restricción `unique` compuesta: `producto_id` + `material_id` (evitar duplicados de insumo en la misma receta).

### Cambios en Seeders
#### [MODIFY] `InsumoSeeder`
- Añadir los insumos faltantes: Etiquetas, Envase 1L, Yogurt Griego Base, Mermeladas por sabor.

#### [NEW] `BomSeeder`
- Poblar las recetas de los 3 tipos de yogurt (YG, YGF, YF) con las cantidades exactas de la tabla proporcionada.

### Cambios en Modelos
#### [MODIFY] `Producto.php`
- Agregar relación `insumos()` vía `belongsToMany` con tabla pivot `bom`.

#### [MODIFY] `Insumo.php`
- Agregar relación inversa `productos()`.

### Controlador y Rutas
#### [NEW] `BomController.php`
- `index(Producto)` — Ver la receta completa del producto.
- `store(Request, Producto)` — Añadir insumo a la receta.
- `update(Request, Producto, $bomId)` — Modificar cantidad/etapa.
- `destroy(Producto, $bomId)` — Quitar insumo de la receta.

### Vistas
#### [MODIFY] `productos/index.blade.php`
- Añadir botón "📋 Receta" por cada producto.

#### [NEW] `productos/bom.blade.php`
- Cabecera con datos del producto.
- Tabla de ingredientes (insumo, cantidad, unidad, etapa).
- Formulario para añadir ingredientes.

---

## Open Questions

> [!IMPORTANT]
> **Pregunta sobre las Mermeladas:**
> Las mermeladas (Fresa, Arándanos, etc.) ¿se compran hechas a un proveedor, o se fabrican internamente a partir de la fruta fresca? Si se fabrican internamente, serían otro nivel de BOM (como el Yogurt Griego Base).

> [!IMPORTANT]
> **Pregunta sobre la Leche UHT en el Inoculante:**
> El DOP muestra que la Mezcla Inoculante usa Leche UHT además del Cultivo. ¿Debemos incluir la Leche UHT en el BOM del Yogurt Frutado, o se considera parte del "Cultivo preparado" y no se contabiliza por separado?
