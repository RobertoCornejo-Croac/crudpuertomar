# Puerto Mar - Sistema de Gestión de Usuarios

## Descripción

 Test de programación del dpto de sistemas por Roberto Carlos Cobeña Cornejo

## Características

### Frontend
- Bootstrap 5.3.2
- DataTable
- jQuery: Manipulación del DOM y AJAX
- Diseño Responsive

### Backend
- PHP: Lenguaje de programación
- PostgreSQL: Base de datos
- PDO: Conexión segura a la base de datos
- BCRYPT: Algoritmo de cifrado para las contraseñas

## Instalación
### Requisitos Previos
- Servidor web (Apache/Nginx)
- PHP 7.4 o superior
- PostgreSQL 12 o superior
- Extensión PDO para PHP

### Pasos de Instalación

1. Clonar o descargar el proyecto
   ```bash
   git clone https://github.com/RobertoCornejo-Croac/crudpuertomar.git
   cd crud_puertomar
   ```

2. Configurar la base de datos
   ```sql
   -- Conectar a PostgreSQL
   psql -U postgres
   
   -- Crear la base de datos
   CREATE DATABASE crud_puertomar;
   
   -- Conectar a la base de datos
   \c crud_puertomar
   
   -- Ejecutar el esquema
   \i sql/schema.sql
   ```

3. Configurar la conexión
   - Editar `db.php` con tus credenciales de PostgreSQL:
   ```php
   $host = 'localhost';
   $port = '5432';
   $dbname = 'crud_puertomar';
   $user = 'tu_usuario';
   $password = 'tu_contraseña';
   ```

### Acceso al Sistema
1. Abrir el navegador
2. Navegar a `http://localhost/crud_puertomar`
3. La interfaz se cargará automáticamente




### Seguridad
- Cifrado de Contraseñas: BCRYPT con salt automático
- Prepared Statements: Previene inyección SQL
- Validación de Datos: Validación tanto en frontend como backend




### Base de Datos
```sql
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    nick VARCHAR(50) NOT NULL UNIQUE,
    clave TEXT NOT NULL
);
```

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





## Tecnologías Utilizadas

| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| Bootstrap | 5.3.2 | Framework CSS |
| DataTables | 1.13.6 | Tablas interactivas |
| jQuery | 3.7.0 | Manipulación DOM/AJAX |
| Font Awesome | 6.4.0 | Iconos |
| PHP | 7.4+ | Backend |
| PostgreSQL | 12+ | Base de datos |
| BCRYPT | - | Cifrado de contraseñas |




## Algoritmo de Cifrado

El sistema utiliza BCRYPT para el cifrado de contraseñas:

```php
$clave_hash = password_hash($clave, PASSWORD_BCRYPT);
```


