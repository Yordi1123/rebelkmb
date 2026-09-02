CREATE TABLE `usuarios` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `correo` varchar(255) UNIQUE,
  `password` varchar(255),
  `rol` varchar(255) COMMENT 'administrador, planificador, operador, etc.',
  `activo` boolean DEFAULT true
);

CREATE TABLE `categorias` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255) COMMENT 'Ej: Yogures, Kombuchas — permite agregar nuevas líneas de producto sin tocar código',
  `descripcion` varchar(255)
);

CREATE TABLE `productos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE COMMENT 'Ej: Y, YF, YG, YGF, KB',
  `nombre` varchar(255),
  `categoria_id` int NOT NULL,
  `tipo` varchar(255) COMMENT 'yogurt_natural, yogurt_frutado, yogurt_griego, yogurt_griego_frutado, kombucha',
  `sabor` varchar(255) COMMENT 'Ej: Fresa, Maracuyá, Arándanos, Coca Muña...',
  `presentacion` varchar(255) COMMENT 'Ej: 1L, 150ml, 150g',
  `unidad_medida` varchar(255),
  `activo` boolean DEFAULT true
);

CREATE TABLE `materiales` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) UNIQUE,
  `nombre` varchar(255),
  `unidad_medida` varchar(255),
  `stock_minimo` decimal,
  `stock_seguridad` decimal,
  `proveedor_id` int NOT NULL
);

CREATE TABLE `proveedores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `contacto` varchar(255),
  `lead_time_dias` int
);

CREATE TABLE `bom` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `producto_id` int NOT NULL,
  `material_id` int NOT NULL,
  `cantidad_requerida` decimal,
  `unidad_medida` varchar(255)
);

CREATE TABLE `clientes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `contacto` varchar(255)
);

CREATE TABLE `pedidos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `cliente_id` int NOT NULL,
  `fecha_pedido` date,
  `fecha_entrega_estimada` date,
  `estado` varchar(255) COMMENT 'pendiente, en_proceso, listo, entregado'
);

CREATE TABLE `pedido_detalle` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` decimal,
  `precio_unitario` decimal
);

CREATE TABLE `pronosticos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `producto_id` int NOT NULL,
  `periodo` date,
  `metodo` varchar(255) COMMENT 'promedio_movil, suavizacion_exponencial, etc.',
  `alfa_suavizacion` decimal,
  `demanda_pronosticada` decimal,
  `demanda_real` decimal
);

CREATE TABLE `plan_mps` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `producto_id` int NOT NULL,
  `periodo` date,
  `stock_inicial` decimal,
  `demanda` decimal,
  `produccion_planificada` decimal,
  `stock_final` decimal,
  `estado` varchar(255)
);

CREATE TABLE `requerimientos_mrp` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `material_id` int NOT NULL,
  `mps_id` int NOT NULL,
  `necesidad_bruta` decimal,
  `disponible` decimal,
  `stock_seguridad` decimal,
  `necesidad_neta` decimal,
  `fecha_requerida` date
);

CREATE TABLE `ordenes_compra` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `proveedor_id` int NOT NULL,
  `material_id` int NOT NULL,
  `cantidad` decimal,
  `fecha_emision` date,
  `lead_time_dias` int,
  `estado` varchar(255) COMMENT 'pendiente, confirmada, recibida'
);

CREATE TABLE `kardex_materiales` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `material_id` int NOT NULL,
  `tipo_movimiento` varchar(255) COMMENT 'entrada (compra), salida (consumo en producción)',
  `cantidad` decimal,
  `fecha` date,
  `stock_resultante` decimal,
  `orden_compra_id` int COMMENT 'Opcional: solo si el movimiento viene de una compra recibida',
  `orden_produccion_id` int COMMENT 'Opcional: solo si el movimiento es consumo en producción',
  `referencia` varchar(255)
);

CREATE TABLE `preinoculo` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo` varchar(255) COMMENT 'FR-PI: código preinóculo',
  `fecha_preparacion` date,
  `fecha_congelacion` date,
  `fecha_uso` date,
  `usuario_id` int,
  `observaciones` varchar(255)
);

CREATE TABLE `puntos_criticos_control` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `orden_produccion_id` int NOT NULL,
  `proceso` varchar(255) COMMENT 'Ej: Recepción de leche, Filtración, Pasteurizado',
  `equipo` varchar(255),
  `cantidad_litros` decimal,
  `hora_inicio` time,
  `hora_final` time,
  `temperatura` decimal,
  `usuario_id` int,
  `observaciones` varchar(255)
);

CREATE TABLE `control_ph` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `lote_id` int NOT NULL,
  `fecha` date,
  `hora` time,
  `ph` decimal,
  `temperatura` decimal,
  `usuario_id` int,
  `observaciones` varchar(255)
);

CREATE TABLE `ordenes_produccion` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `producto_id` int NOT NULL,
  `fecha_planificada` date,
  `fecha_real` date,
  `cantidad_planificada` decimal,
  `cantidad_real` decimal,
  `estado` varchar(255)
);

CREATE TABLE `lotes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo_lote` varchar(255) UNIQUE COMMENT 'Ej: Y-300426-01, KB-...',
  `producto_id` int NOT NULL,
  `orden_produccion_id` int NOT NULL,
  `preinoculo_id` int COMMENT 'Opcional: solo aplica a lotes de yogurt',
  `fecha_produccion` date,
  `fecha_envasado` date,
  `fecha_vencimiento` date,
  `volumen_base` decimal,
  `cantidad_producida` decimal,
  `cultivo_utilizado` varchar(255),
  `usuario_id` int,
  `estado` varchar(255) COMMENT 'vigente, vencido',
  `observaciones` varchar(255)
);

CREATE TABLE `producto_terminado` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `lote_id` int NOT NULL,
  `cantidad_disponible` decimal,
  `ubicacion_almacen` varchar(255)
);

CREATE TABLE `kardex` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `producto_id` int NOT NULL,
  `lote_id` int NOT NULL,
  `tipo_movimiento` varchar(255) COMMENT 'entrada, salida',
  `cantidad` decimal,
  `fecha` date,
  `stock_resultante` decimal,
  `referencia` varchar(255) COMMENT 'Ej: referencia a pedido o despacho'
);

CREATE TABLE `despachos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `producto_terminado_id` int NOT NULL,
  `fecha_despacho` date,
  `cantidad` decimal,
  `estado` varchar(255)
);

ALTER TABLE `productos` ADD FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

ALTER TABLE `materiales` ADD FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`);

ALTER TABLE `bom` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `bom` ADD FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`);

ALTER TABLE `pedidos` ADD FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

ALTER TABLE `pedido_detalle` ADD FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

ALTER TABLE `pedido_detalle` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `pronosticos` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `plan_mps` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `requerimientos_mrp` ADD FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`);

ALTER TABLE `requerimientos_mrp` ADD FOREIGN KEY (`mps_id`) REFERENCES `plan_mps` (`id`);

ALTER TABLE `ordenes_compra` ADD FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`);

ALTER TABLE `ordenes_compra` ADD FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`);

ALTER TABLE `kardex_materiales` ADD FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`);

ALTER TABLE `kardex_materiales` ADD FOREIGN KEY (`orden_compra_id`) REFERENCES `ordenes_compra` (`id`);

ALTER TABLE `kardex_materiales` ADD FOREIGN KEY (`orden_produccion_id`) REFERENCES `ordenes_produccion` (`id`);

ALTER TABLE `preinoculo` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `puntos_criticos_control` ADD FOREIGN KEY (`orden_produccion_id`) REFERENCES `ordenes_produccion` (`id`);

ALTER TABLE `puntos_criticos_control` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `control_ph` ADD FOREIGN KEY (`lote_id`) REFERENCES `lotes` (`id`);

ALTER TABLE `control_ph` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `ordenes_produccion` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `lotes` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `lotes` ADD FOREIGN KEY (`orden_produccion_id`) REFERENCES `ordenes_produccion` (`id`);

ALTER TABLE `lotes` ADD FOREIGN KEY (`preinoculo_id`) REFERENCES `preinoculo` (`id`);

ALTER TABLE `lotes` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `producto_terminado` ADD FOREIGN KEY (`lote_id`) REFERENCES `lotes` (`id`);

ALTER TABLE `kardex` ADD FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

ALTER TABLE `kardex` ADD FOREIGN KEY (`lote_id`) REFERENCES `lotes` (`id`);

ALTER TABLE `despachos` ADD FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

ALTER TABLE `despachos` ADD FOREIGN KEY (`producto_terminado_id`) REFERENCES `producto_terminado` (`id`);
