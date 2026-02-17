# Guía de migración para Docker

## Cambios en la Aplicación

La aplicación ya está configurada para funcionar con Docker. A continuación se detallan los cambios realizados:

### 1. Configuración de Base de Datos

**Archivo**: `usuariosConfig/BBDD/MySQL/configMySQL.php`

Se ha actualizado para leer variables de entorno de Docker:

```php
$serverDB = getenv('DB_HOST') ?: 'localhost';
$usernameDB = getenv('MYSQL_USER') ?: 'gsh_user';
$passwordDB = getenv('MYSQL_PASSWORD') ?: 'gsh_pass';
$esquemaDB = getenv('MYSQL_DATABASE') ?: 'usuarios';
```

**Configuración en Docker**:
- En `docker-compose.yml` se pasan las variables de entorno
- En `.env` se pueden personalizar los valores

### 2. Actualización de Conexión PDO

**Archivo**: `usuariosConfig/BBDD/MySQL/conexionMySQL.php`

Se ha mejorado la función de conexión para usar PDO con mejor manejo de errores:
- Soporte completo para UTF-8
- Configuración automática de charset
- Mejor manejo de excepciones

## Cómo usar en Desarrollo

### Primer uso:

```bash
# 1. Copiar variables de entorno
cp .env.example .env

# 2. Iniciar Docker
./docker.sh start

# 3. Verificar que está corriendo
./docker.sh status

# 4. Acceder a la aplicación
# http://localhost:8080
```

### Operaciones comunes:

```bash
# Ver logs en tiempo real
./docker.sh logs

# Acceder a la terminal PHP
./docker.sh bash

# Conectarse a MySQL
./docker.sh mysql

# Hacer backup de BD
./docker.sh db-backup

# Ejecutar comando PHP
./docker.sh php -v
```

## Variables de Entorno

El archivo `.env` controla la configuración:

```env
# Base de Datos
MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=gsh
MYSQL_USER=gsh_user
MYSQL_PASSWORD=gsh_pass

# Aplicación
DB_HOST=db
DB_PORT=3306
```

**Importante**: Para producción, cambiar:
- `MYSQL_ROOT_PASSWORD`
- `MYSQL_PASSWORD`
- Y no hacer commit de `.env` a Git

## Estructura de Volúmenes

- **Código de la aplicación**: Montado en tiempo real desde el host
- **Base de datos**: Persistente en volumen de Docker `db_data`
- **Archivos subidos**: Directorio `archivos/` persiste entre reinicios

## Si la aplicación usa archivos externos

Si `usuariosConfig/` tiene archivos que no se han incluido, puedes:

1. Copiarlos a `usuariosConfig/` en el contenedor:
   ```bash
   ./docker.sh bash
   # Luego pega los archivos necesarios
   ```

2. O monta un volumen adicional en `docker-compose.yml`:
   ```yaml
   volumes:
     - /ruta/externa/archivo.php:/var/www/html/ruta/archivo.php:ro
   ```

## Troubleshooting

### "No se puede conectar a la base de datos"

```bash
# 1. Verificar que el contenedor db está corriendo
./docker.sh status

# 2. Ver logs de error
./docker.sh logs-db

# 3. Probar conexión directa
./docker.sh mysql
```

### "Puerto 8080 en uso"

Cambiar en `docker-compose.yml`:
```yaml
ports:
  - "8081:80"  # Cambiar a otro puerto
```

Luego acceder a: http://localhost:8081

## Próximos pasos

1. **Restaurar base de datos**:
   - Colocar archivo SQL en `docker/mysql/init/`
   - Reiniciar Docker: `./docker.sh down && ./docker.sh start`

2. **Configurar credenciales reales**:
   - Editar `.env` con valores deseados
   - Ejecutar `./docker.sh reset` para limpiar BD anterior

3. **Personalizar Nginx/PHP**:
   - Editar `docker/nginx/000-default.conf` para reescrituras de URL
   - Editar `docker/php/php.ini` para limites y extensiones

4. **Control de versiones**:
   - `git add` todos los archivos Docker
   - NO hacer commit de `.env` (solo `.env.example`)

---

¿Necesitas ayuda? Consulta `DOCKER.md` para documentación completa.
