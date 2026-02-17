# Configuración Avanzada de Docker

Guía para configuraciones avanzadas y optimizaciones.

## 🔧 Personalización de PHP

### Aumentar límites de memoria y tiempo

Editar `docker/php/php.ini`:

```ini
; Aumentar para procesamiento pesado
memory_limit = 512M
max_execution_time = 600

; Para API pesadas
post_max_size = 100M
upload_max_filesize = 100M

; Para muchas conexiones
max_input_nesting_level = 128
```

### Agregar extensiones PHP

En `Dockerfile`, agregar después de `docker-php-ext-install`:

```dockerfile
# Ejemplo: agregar extensión cURL y opcache
RUN docker-php-ext-install -j$(nproc) \
    curl \
    opcache

# Habilitar opcache en php.ini
RUN echo "zend_extension=opcache.so" >> /usr/local/etc/php/conf.d/custom.ini
```

Luego reconstruir:
```bash
./docker.sh rebuild
```

### Activar caché de opcache

```ini
# En docker/php/php.ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=7963
opcache.validate_timestamps=0
opcache.revalidate_freq=0
```

## 🔄 Base de Datos Avanzada

### Crear scripts de inicialización

En `docker/mysql/init/`, crear archivos SQL nombrados en orden:

```bash
docker/mysql/init/
├── 01_create_tables.sql       # Estructura tablas
├── 02_seed_data.sql           # Datos iniciales
└── 03_indexes.sql             # Índices
```

Se ejecutarán automáticamente en orden alfabético.

### Configuración MySQL avanzada

Crear `docker/mysql/my.cnf`:

```ini
[mysqld]
# Caché de queries
query_cache_type = 1
query_cache_size = 64M
query_cache_limit = 2M

# Conexiones
max_connections = 100
max_allowed_packet = 64M

# Logs
log_queries_not_using_indexes = 1
slow_query_log = 1
long_query_time = 2

# InnoDB
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
```

Luego en `docker-compose.yml`:

```yaml
db:
  volumes:
    - ./docker/mysql/my.cnf:/etc/mysql/conf.d/my.cnf
```

### Backup automático

Crear `docker/backup.sh`:

```bash
#!/bin/bash
DATE=$(date +\%Y\%m\%d_%H\%M\%S)
docker-compose exec -T db mysqldump \
  -u gsh_user \
  -pgsh_pass \
  gsh > "backups/usuarios_${DATE}.sql"
```

Configurar cron (Linux/Mac):

```bash
# Ejecutar backup diariamente a las 2 AM
0 2 * * * cd /ruta/proyecto && ./docker/backup.sh
```

## 🌐 Nginx Avanzado

### Habilitar HTTPS con Let's Encrypt

Crear `docker/nginx/nginx.conf`:

```nginx
server {
    listen 443 ssl http2;
    server_name tu_dominio.com;

    ssl_certificate /etc/letsencrypt/live/tu_dominio.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/tu_dominio.com/privkey.pem;

    location / {
        proxy_pass http://app:80;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}

server {
    listen 80;
    server_name tu_dominio.com;
    return 301 https://$server_name$request_uri;
}
```

### Reescrituras de URL complejas

En `docker/nginx/000-default.conf`:

```nginx
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    # No reescribir archivos/directorios existentes
    RewriteCond %{REQUEST_FILENAME} -f
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^.*$ - [L]

    # Reescribir a index.php
    RewriteRule ^(.*)$ index.php?url=$1 [L,QSA]
</IfModule>
```

### Gzip y compresión

```nginx
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/xml
</IfModule>
```

## 📊 Monitoreo y Logs

### Logs estructurados

En `docker/php/php.ini`:

```ini
; Enviar logs a stdout para Docker
error_log = /proc/self/fd/2
log_errors = 1
```

### Configurar Graylog o ELK Stack

Agregar en `docker-compose.yml`:

```yaml
services:
  app:
    logging:
      driver: "json-file"
      options:
        max-size: "10m"
        max-file: "3"
```

### Ver logs en tiempo real

```bash
# Seguir logs
docker-compose logs -f app

# Últimas 100 líneas
docker-compose logs --tail=100 app

# Con timestamps
docker-compose logs -f --timestamps app
```

## 🚀 Optimización de Rendimiento

### Usar volúmenes nombrados para BD

Mejor rendimiento que bind mounts:

```yaml
volumes:
  db_data:
    driver: local
    driver_opts:
      type: none
      o: bind
      device: /ruta/local/datos
```

### Caché multi-stage en Dockerfile

```dockerfile
# Stage 1: Builder
FROM php:7.3 as builder
RUN apt-get update && apt-get install -y ... && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install ...

# Stage 2: Runtime
FROM php:7.3-nginx
COPY --from=builder /usr/local/etc/php /usr/local/etc/php
```

### Limitar recursos

```yaml
services:
  app:
    deploy:
      resources:
        limits:
          cpus: '0.5'
          memory: 512M
        reservations:
          cpus: '0.25'
          memory: 256M
```

## 🔒 Seguridad Avanzada

### Restricciones de archivo

En `docker/nginx/000-default.conf`:

```nginx
# Bloquear archivos sensibles
<FilesMatch "\.php$">
    <If "-f %{REQUEST_FILENAME}">
        SetHandler "proxy:unix:/run/php/php-fpm.sock|fcgi://localhost"
    </If>
</FilesMatch>

# Bloquear acceso a .env
<Files ".env*">
    Deny from all
</Files>

# Bloquear acceso a git
<Directory ".git">
    Deny from all
</Directory>
```

### Rate limiting

```nginx
<IfModule mod_ratelimit.c>
    <Location "/api/">
        SetOutputFilter RATE_LIMIT
        ModRateLimit 100
    </Location>
</IfModule>
```

### WAF (Web Application Firewall)

Usar ModSecurity:

```nginx
<IfModule mod_security.c>
    SecRuleEngine On
    SecRule ARGS "@contains <script" "id:1000,phase:2,block"
</IfModule>
```

## 🐛 Debug Avanzado

### Xdebug para debugging remoto

Agregar en `Dockerfile`:

```dockerfile
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
```

Crear `docker/php/xdebug.ini`:

```ini
[xdebug]
xdebug.remote_enable = 1
xdebug.remote_host = host.docker.internal
xdebug.remote_port = 9000
xdebug.mode = debug
xdebug.start_with_request = yes
```

### Profiling

```php
<?php
xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
// ... código a perfilar ...
$coverage = xdebug_get_code_coverage();
?>
```

## 📦 Integración CI/CD

### GitHub Actions

Crear `.github/workflows/docker.yml`:

```yaml
name: Docker Build

on: [push]

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Run verification
        run: ./verificar-docker.sh
      - name: Build image
        run: docker-compose build
      - name: Start services
        run: docker-compose up -d
      - name: Run tests
        run: docker-compose exec -T app php vendor/bin/phpunit
```

### GitLab CI

Crear `.gitlab-ci.yml`:

```yaml
docker-build:
  stage: build
  image: docker:latest
  services:
    - docker:dind
  script:
    - docker-compose build
    - docker-compose up -d
    - docker-compose exec -T app php -v
```

## 🔗 Múltiples entornos

### docker-compose.dev.yml

```yaml
version: '3.8'
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile.dev
    environment:
      - PHP_DISPLAY_ERRORS=1
      - DB_DEBUG=1
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www/html:cached
```

Usar con:
```bash
docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d
```

### docker-compose.prod.yml

```yaml
version: '3.8'
services:
  app:
    image: usuarios:1.0.0
    environment:
      - PHP_DISPLAY_ERRORS=0
    ports:
      - "80:80"
```

## 📚 Referencias

- [Docker Best Practices](https://docs.docker.com/develop/develop-images/dockerfile_best-practices/)
- [Nginx Modules](https://httpd.nginx.org/docs/2.4/mod/)
- [MySQL Optimization](https://dev.mysql.com/doc/refman/8.0/en/optimization.html)
- [PHP Configuration](https://www.php.net/manual/en/ini.php)
