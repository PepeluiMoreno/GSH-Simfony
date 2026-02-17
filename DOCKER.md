# Dockerización de Aplicación GSH

Guía completa para ejecutar la aplicación con Docker.

## 📋 Requisitos Previos

- [Docker](https://www.docker.com/products/docker-desktop) versión 20.10 o superior
- [Docker Compose](https://docs.docker.com/compose/install/) versión 1.29 o superior
- En Linux, ejecuta Docker sin sudo: `sudo usermod -aG docker $USER`

## 🚀 Inicio Rápido

### 1. Clonar variables de entorno

```bash
cp .env.example .env
```

Edita `.env` si necesitas cambiar las credenciales por defecto:
- `MYSQL_ROOT_PASSWORD`: Contraseña de root de MySQL (default: `root`)
- `MYSQL_DATABASE`: Nombre de la base de datos (default: `gsh`)
- `MYSQL_USER`: Usuario de MySQL (default: `gsh_user`)
- `MYSQL_PASSWORD`: Contraseña del usuario MySQL (default: `gsh_pass`)

### 2. Construir e iniciar los contenedores

```bash
docker-compose up -d
```

Este comando:
- Construye la imagen de PHP/Nginx
- Inicia los contenedores de aplicación y base de datos
- Crea volúmenes para persistencia de datos

### 3. Acceder a la aplicación

La aplicación estará disponible en:
- **URL**: http://optiplex-790:8080
- **Base de datos**: `db` (hostname interno desde el contenedor) o `optiplex-790:3306` (acceso externo)

## 📦 Estructura de Contenedores

```
┌─────────────────────────────────────────────────────────┐
│                  Docker Network                         │
│  ┌──────────────────┐        ┌──────────────────┐      │
│  │   gsh_app   │◄──────►│   gsh_db    │      │
│  │  (PHP 7.3/Nginx)│        │  (MariaDB 10.5)  │      │
│  │   puerto: 8080   │        │  puerto: 3306    │      │
│  └──────────────────┘        └──────────────────┘      │
└─────────────────────────────────────────────────────────┘
```

## 🛠️ Comandos Utiles

### Gestión de contenedores

```bash
# Ver estado de los contenedores
docker-compose ps

# Detener contenedores
docker-compose stop

# Reiniciar contenedores
docker-compose restart

# Detener y eliminar contenedores
docker-compose down

# Eliminar contenedores e imágenes
docker-compose down --rmi all
```

### Logs

```bash
# Ver logs de la aplicación PHP
docker-compose logs app -f

# Ver logs de MySQL
docker-compose logs db -f

# Ver logs de todos los servicios
docker-compose logs -f
```

### Acceso a contenedores

```bash
# Terminal interactiva en el contenedor PHP
docker-compose exec app bash

# Terminal interactiva en MySQL
docker-compose exec db mariadb -u root -p gsh

# Ejecutar comando PHP
docker-compose exec app php -v
```

### Base de datos

```bash
# Acceder a MySQL con client
docker-compose exec db mysql -u gsh_user -pgsh_pass gsh

# Hacer backup de la base de datos
docker-compose exec db mysqldump -u gsh_user -pgsh_pass gsh > backup.sql

# Restaurar desde backup
docker exec gsh_db mysql -u gsh_user -pgsh_pass gsh < backup.sql
```

## 📁 Estructura de archivos Docker

```
├── Dockerfile                      # Configuración de imagen PHP/Nginx
├── docker-compose.yml              # Orquestación de servicios
├── .dockerignore                   # Archivos a excluir en build
├── .env.example                    # Variables de entorno (ejemplo)
└── docker/
    ├── nginx/
    │   └── 000-default.conf        # Configuración de VirtualHost
    ├── php/
    │   └── php.ini                 # Configuración personalizada PHP
    └── mysql/
        └── init/                   # Scripts SQL iniciales (opcional)
            └── .gitkeep
```

## 🔧 Configuración

### PHP 7.3.21

La configuración incluye:
- **Módulos instalados**: mysqli, PDO, PDO MySQL, GD
- **Max upload**: 50 MB
- **Max execution time**: 300 segundos
- **Zona horaria**: Europe/Madrid
- **Memory limit**: 256 MB

Ver archivo: `docker/php/php.ini`

### Nginx

Configurado con:
- **Módulo rewrite habilitado**
- **VirtualHost en puerto 80** (expuesto como 8080)
- **DirectoryIndex personalizado**
- **Protección de directorios**: controladores/ y modelos/ bloqueados

Ver archivo: `docker/nginx/000-default.conf`

### MariaDB 10.5

- **Base de datos**: gsh
- **Character set**: utf8mb4
- **Puerto**: 3306
- **Persistencia**: Volumen `db_data`

## 🗄️ Base de Datos

### Importar dump existente

Si tienes un archivo SQL de base de datos:

```bash
# Copiar el archivo SQL en docker/mysql/init/
cp tu_backup.sql docker/mysql/init/01_gsh.sql

# Reiniciar los contenedores para que se ejecute el script
docker-compose down
docker-compose up -d
```

Los scripts SQL en `docker/mysql/init/` se ejecutan automáticamente al iniciar el contenedor.

### Crear tablas manualmente

```bash
docker-compose exec db mariadb -u gsh_user -pgsh_pass gsh

# Luego pegué tus comandos SQL CREATE TABLE
```

## 🔒 Consideraciones de Seguridad

### ⚠️ IMPORTANTE: Para PRODUCCIÓN

1. **Cambiar credenciales por defecto**
   ```bash
   # En .env, cambiar:
   MYSQL_ROOT_PASSWORD=tu_password_fuerte
   MYSQL_PASSWORD=contraseña_aleatoria
   ```

2. **Deshabilitar display_errors**
   ```
   php.ini: display_errors = 0 ✓ (ya configurado)
   ```

3. **Limitar acceso a Nginx**
   ```
   El archivo 000-default.conf bloquea acceso directo a:
   ✓ /controladores/
   ✓ /modelos/
   ```

4. **Por defecto, la base de datos solo es accesible desde docker**
   - MySQL puerto 3306 está expuesto (cambiar en docker-compose.yml si lo necesitas ocultar)

## 🐛 Solución de Problemas

### **Puerto 8080 ya está en uso**

```bash
# Opción 1: Cambiar puerto en docker-compose.yml
# Cambiar "8080:80" por "8081:80"

# Opción 2: Liberar el puerto
lsof -i :8080
kill -9 <PID>
```

### **La app no puede conectarse a la base de datos**

```bash
# 1. Verificar que el contenedor db está corriendo
docker-compose ps

# 2. Ver logs de error
docker-compose logs db

# 3. Verificar credenciales en .env
cat .env

# 4. Verificar que configMySQL.php usa las variables correctas
```

### **Permisos denegados en archivos subidos**

```bash
# Ajustar permisos en contenedor
docker-compose exec app chmod -R 755 archivos
docker-compose exec app chown -R www-data:www-data archivos
```

### **La aplicación es lenta**

```bash
# Aumentar memoria PHP en docker/php/php.ini
memory_limit = 512M

# Aumentar en docker-compose.yml:
# tmpfs:
#   - /tmp
#   - /var/tmp

# Reiniciar
docker-compose restart
```

## 📊 Monitoreo

### Ver uso de recursos

```bash
docker stats
```

### Ver eventos de Docker

```bash
docker events
```

## 🔄 Desarrollo

### Cambios en código PHP

Los cambios en `.php` se reflejan inmediatamente (volumen montado).

### Cambios en Dockerfile o dependencias

```bash
# Reconstruir imagen
docker-compose up -d --build

# Reconstruir sin caché
docker-compose up -d --build --no-cache
```

### Cambios en docker-compose.yml

```bash
# Reiniciar servicios
docker-compose down
docker-compose up -d
```

## 🚢 Despliegue a Producción

### Preparación

1. **Usar variables de entorno seguros**
   ```bash
   # NO commit .env a git
   echo ".env" >> .gitignore
   ```

2. **Usar secrets de Docker Swarm o Kubernetes**

3. **Usar image tags versionados**
   ```bash
   docker build -t usuarios:1.0.0 .
   ```

4. **Usar reverse proxy (nginx)**

### Ejemplo con nginx reverse proxy

```yaml
# docker-compose.yml - agregar servicio nginx
  nginx:
    image: nginx:latest
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./docker/nginx/nginx.conf:/etc/nginx/nginx.conf
    depends_on:
      - app
```

## 📚 Referencias

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [PHP 7.3 Docker](https://hub.docker.com/_/php)
- [MariaDB Docker](https://hub.docker.com/_/mariadb)
- [Nginx Docker](https://hub.docker.com/_/httpd)

## 💡 Tips

- Utiliza `docker-compose up -d` para ejecutar en background
- Usa `docker-compose logs -f` para debug en tiempo real
- Realiza backups regulares: `docker-compose exec db mysqldump -u root -p --all-databases > backup.sql`
- Mantén Docker y las imágenes actualizadas

---

¿Preguntas? Revisa los logs: `docker-compose logs app`
