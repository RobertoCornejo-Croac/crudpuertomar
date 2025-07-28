-- Tabla de embarcaciones
CREATE TABLE IF NOT EXISTS embarcaciones (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ano_construccion INTEGER NOT NULL,
    tipo_barco VARCHAR(50) NOT NULL,
    capacidad_carga DECIMAL(10,2) NOT NULL,
    usuario_id INTEGER,
    foto VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Índices para mejorar rendimiento
CREATE INDEX IF NOT EXISTS idx_embarcaciones_usuario ON embarcaciones(usuario_id);
CREATE INDEX IF NOT EXISTS idx_embarcaciones_tipo ON embarcaciones(tipo_barco); 