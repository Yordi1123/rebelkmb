# Manual de Usuario: Gestión de Proveedores e Insumos

Este documento describe el flujo operativo recomendado para gestionar la materia prima (Insumos) y la cadena de suministro (Proveedores) dentro del sistema MRP de Rebel KMB.

---

## 1. Orden de Operaciones (Flujo Lógico)

Para mantener la integridad de la base de datos y facilitar la carga de información, se debe seguir estrictamente este orden al registrar nuevos elementos en el sistema:

1. **Categorías de Insumos** (Si aplica, registrar primero si la categoría no existe).
2. **Proveedores**: Registrarlos primero, ya que son un pre-requisito para los insumos.
3. **Insumos**: Registrar la materia prima vinculándola al proveedor correspondiente.

> [!TIP]
> **¿Por qué este orden?**
> No puedes registrar un insumo y asignarle un proveedor si este último no existe en el sistema. Empezar por el catálogo de proveedores te ahorrará interrupciones durante la creación de insumos.

---

## 2. Módulo de Proveedores

Este módulo te permite gestionar a las empresas que suministran los materiales para la producción.

### Crear un Proveedor
Dirígete a **Operaciones > Proveedores** y haz clic en `+ Nuevo proveedor`. 

**Campos clave a tener en cuenta:**
- **Razón Social:** Nombre de la empresa. **(Obligatorio y Único)**. No pueden existir dos proveedores con el mismo nombre.
- **RUC:** **(Opcional, pero Único)**. Si decides ingresarlo, el sistema verificará que sean **exactamente 11 dígitos numéricos**.
- **Lead Time (Días):** Es el tiempo estimado (en días) que tarda el proveedor en entregarte el pedido desde el momento en que emites la orden de compra. Este dato es vital para la planificación (MRP).

### Restricciones de Seguridad
> [!CAUTION]
> **Eliminación bloqueada**
> Si un proveedor ya tiene uno o más **Insumos** asignados en el sistema, el botón de eliminar estará deshabilitado o lanzará un error de seguridad. Para eliminar un proveedor, primero deberás reasignar o eliminar los insumos que este provee.

---

## 3. Módulo de Insumos (Materia Prima)

Este módulo es el corazón de tu inventario. Aquí configuras los parámetros de los materiales que luego se usarán en las recetas (BOM).

### Crear un Insumo
Dirígete a **Catálogos > Insumos** y haz clic en `+ Nuevo insumo`.

**Campos clave a tener en cuenta:**
- **Código y Nombre:** Ambos deben ser **únicos**. El código (ej. `AGUA`, `AZUC`) se usará en las tablas de formulación.
- **Proveedor:** Selecciona el proveedor de la lista desplegable. Si cambias de proveedor en el futuro, puedes editarlo aquí.
- **Stock Mínimo:** Nivel de inventario que dispara una alerta (Stock Bajo) indicando que es hora de planificar una compra.
- **Stock de Seguridad:** Es el "colchón" de emergencia. El sistema valida que este número **jamás sea mayor que el Stock Mínimo**.

### Política de Modificación de Inventario
> [!IMPORTANT]
> **Regla de Inmutabilidad Manual del Stock**
> 
> Durante la *creación* de un insumo, puedes definir su stock inicial si estás haciendo una carga inicial del sistema. 
> 
> Sin embargo, **al editar un insumo existente**, el campo "Stock Actual" estará **bloqueado (Modo solo lectura)**.
> 
> **¿Por qué?** Para garantizar la trazabilidad (Kardex). El stock no debe modificarse "a dedo". Las variaciones de inventario deben ocurrir automáticamente mediante:
> 1. Ingreso de Órdenes de Compra (Suma stock).
> 2. Despacho a Producción (Resta stock).
> 3. Módulo de Ajustes de Inventario/Mermas (Aún por desarrollar).

### Monitoreo en la Vista Principal
En la tabla de Insumos, presta atención a la columna **Estado**. Si el stock actual de una materia prima cae por debajo de su Stock Mínimo configurado, el sistema marcará esa fila automáticamente con un badge rojo de `⚠ Stock bajo`, indicando que requiere acción de compras.
