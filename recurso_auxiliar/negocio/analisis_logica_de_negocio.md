**Análisis de Lógica de Negocio – Caso REBEL Kombucha**

* **Interpretación de Excel 1: YOGURT – REGISTRO 2026**

Este libro de Excel, titulado "YOGURT-REGISTRO2026.xlsx", funciona como un sistema integral de registro y control operativo para la producción, calidad y gestión de inventario de una planta elaboradora de yogurt para el año 2026.

A partir de las hojas y tablas que contiene, el archivo trata principalmente los siguientes aspectos:

1. Control de Inventario (Kardex): Cuenta con varias hojas dedicadas a registrar los ingresos, salidas y el stock actual de diferentes productos terminados. Por ejemplo, lleva el control detallado del Yogurt Griego Frutado de 150g, Yogurt Griego estándar y Yogurt Frutado de 1 litro, especificando lotes, fechas y cantidades por sabor (como fresa, maracumango, arándanos y piña).
2. Trazabilidad y Registro de Lotes: Incluye formatos (como el FR-RL-Y-001) para registrar cada lote de producción. Allí se documentan datos clave como el volumen base producido, las fechas de elaboración, envasado y vencimiento, así como los cultivos lácteos utilizados y los responsables del proceso.
3. Control de Calidad y Procesos: Contiene registros de Control de Puntos Críticos (FR-PCP-Y-001) para monitorear rigurosamente los procesos de elaboración, controlando variables como la temperatura, los tiempos de inicio y fin en los equipos (ollas) y los volúmenes manejados. También incluye un formato para el registro de preinóculos.
4. Estandarización Documental: Posee una hoja de CODIFICACIÓN que establece las reglas y significados de los códigos utilizados en los documentos y procesos de la planta, asegurando un estándar en toda la operación.

En resumen, es una herramienta diseñada para asegurar la trazabilidad completa del producto desde su elaboración hasta su almacenamiento, garantizando el control de calidad y la correcta gestión del inventario de la empresa.

**Interpretación de Excel 2: KOMBUCHA – REGISTRO 2026**

El libro de Excel titulado **"KOMBUCHA-REGISTRO 2026.xlsx"** cumple una función muy similar al de yogurt, pero está diseñado específicamente para gestionar de manera integral la **producción, calidad e inventario de la línea de Kombucha** durante el año 2026.

A partir de la información contenida, el archivo trata los siguientes aspectos clave:

1. **Diagramas de Operaciones de Proceso (DOP):** Cuenta con múltiples hojas (como DOP-KBBASE-001, DOP-KBF-001, DOP-KBCM-001, etc.) que detallan paso a paso las actividades de producción (operación, espera, combinado, almacenado y transporte) y los tiempos requeridos tanto para la kombucha base como para sus diferentes sabores.
2. **Control de Calidad (pH y Temperatura):** Dado que la kombucha es una bebida fermentada, requiere un control estricto de acidez. El archivo incluye el formato FR-PH-KB-001 destinado exclusivamente a registrar el pH diario y la temperatura de los lotes.
3. **Trazabilidad y Registro de Lotes:** Utiliza el formato FR-RL-KB-001 para documentar cada lote de kombucha producido. Aquí se registran fechas críticas (como el inicio de la fermentación y la fecha de envasado), el pH final, la cantidad producida, la fecha de vencimiento y el sabor elaborado (Fresa, Coca-Muña, Arándanos, Piña-Jengibre, Maracuyá y Hierba Luisa).
4. **Control de Inventario (Kardex):** A través de la hoja KDX-KB-001, lleva un conteo exacto de las botellas de kombucha (en presentación de 330ml) que ingresan y salen, manteniendo el stock actualizado y desglosado por cada uno de los sabores.
5. **Codificación:** Al igual que el archivo de yogurt, establece una estandarización de códigos para identificar documentos y etapas únicas de esta bebida, como "Preinóculo" (PI), "Barril de fermentación" (FK) y "Segunda fermentación" (SFK).

En resumen, es el sistema central de control operativo para la elaboración de kombucha, garantizando que se respeten los tiempos de fermentación, los niveles de acidez y el inventario exacto de las diferentes variedades que produce la planta.

* **Requerimiento para desarrollar sistema**

Para transformar la gestión actual (basada en los libros de Excel de Yogurt y Kombucha) en un verdadero **Sistema de Información (SI)** estructurado, robusto y escalable, debes dejar de pensar en "hojas de cálculo" y empezar a pensar en **bases de datos relacionales y flujos de procesos**.

Aquí tienes los puntos clave que debes comprender y estructurar para desarrollar el sistema correctamente:

**1. Arquitectura de Datos (De hojas a Tablas Relacionales)**

En Excel, la información suele repetirse o estar aislada. En un SI, debes separar los datos "Maestros" (que rara vez cambian) de los datos "Transaccionales" (el día a día).

* **Datos Maestros (Catálogos):**
  + *Productos:* Yogurt Natural, Kombucha Fresa, Cultivos, etc. (con sus presentaciones y códigos únicos).
  + *Recetas/DOP:* Los tiempos estándar, pasos y temperaturas para cada producto.
  + *Usuarios/Personal:* Operarios, supervisores de calidad (Ej. Milagros Jave, José Vise).
* **Datos Transaccionales:**
  + *Lotes de Producción:* Cada vez que se inicia un proceso (Ej. Lote KB-MR-170426).
  + *Registros de Calidad:* Lecturas diarias de pH, temperaturas, horas de inicio/fin.
  + *Movimientos de Inventario:* Entradas (por producción) y Salidas (por ventas/mermas).

**2. Trazabilidad Integral (End-to-End)**

El sistema debe ser capaz de rastrear un producto terminado hacia atrás, hasta su origen.

* **El Lote es el Rey:** El "Código de Lote" debe ser la llave que conecte todo. Si tienes una botella de Kombucha de Fresa, el sistema debe decirte:
  + Cuándo inició su fermentación.
  + Qué mediciones de pH y temperatura tuvo cada día.
  + En qué barril o tanque estuvo.
  + Quién fue el responsable de aprobarlo.

**3. Automatización del Kardex (Inventario)**

En tus Excel actuales, alguien debe tipear los ingresos y salidas. En un Sistema de Información, el Kardex no se digita, **se calcula automáticamente**:

* **Ingresos automáticos:** Cuando el supervisor de calidad aprueba un "Registro de Lotes" y marca el producto como "Envasado", el sistema debe sumar automáticamente esa cantidad al stock.
* **Salidas:** Se registrarán a través de un módulo de "Despacho" o "Ventas", restando automáticamente del stock.
* *Mejora:* El sistema debe incluir alertas de stock mínimo y alertas de fechas de vencimiento próximas (FEFO: Primero en expirar, primero en salir).

**4. Digitalización del Control de Calidad (HACCP)**

Tus formatos de Puntos Críticos (FR-PCP-Y-01) y Control de pH (FR-PH-KB-01) son vitales para la inocuidad alimentaria.

* **Validaciones en tiempo real:** El sistema no debe permitir ingresar un pH fuera del rango permitido sin exigir una "Observación" o levantar una alerta.
* **Tiempos y Trazabilidad:** En lugar de escribir "Hora inicio / Hora fin", el sistema puede usar botones de "Iniciar Proceso" y "Finalizar Proceso" que capturen la hora exacta del servidor, evitando manipulaciones.

**5. Gestión de Roles, Permisos y Firmas**

Tus documentos actuales tienen campos de "Elaborado por", "Revisado por" y "Aprobado por".

* Un SI requiere control de acceso (Login).
* **Operarios:** Solo pueden registrar datos de producción (temperaturas, pH, volúmenes).
* **Calidad/Jefatura:** Tienen el permiso para hacer clic en "Aprobar Lote", lo que bloquea el registro para que no sea modificado posteriormente (Auditoría).

**6. Estandarización Estricta (Cero texto libre)**

En los Excel, un operario puede escribir "Arandanos", "Arándano", "arandano", lo que arruina los reportes.

* Tu pestaña actual de **"CODIFICACIÓN"** debe convertirse en la regla estricta del sistema.
* Todo debe funcionar con **menús desplegables (combobox)**. Si se va a registrar un sabor, se elige de una lista cerrada. Si se va a registrar una observación común ("Gasificación correcta"), debe ser un check o una lista, dejando el texto libre solo para anomalías.

**7. Reportes y Dashboards en Tiempo Real**

El objetivo final de reemplazar Excel es la visibilidad. El sistema debe procesar los datos para mostrarte pantallas (Dashboards) con:

* Rendimiento de producción (Litros producidos vs. Litros esperados).
* Curvas de fermentación (Gráficos automáticos de cómo bajó el pH de la Kombucha a lo largo de los días).
* Valorización del inventario actual.

**¿Por dónde empezar?**

Para construir este sistema, te sugiero empezar diseñando el **Diagrama de Entidad-Relación (DER)** de la base de datos basándote en los campos exactos que ya tienes en tus Excel, y luego definir el **Flujo de Usuario** (qué pantallas verá el operario en la planta vs. qué pantallas verá el gerente en su oficina).