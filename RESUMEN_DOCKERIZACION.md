# ✅ Proyecto Dockerizado - Resumen de Cambios

## 📦 Archivos Creados

### Configuración Docker
```
✓ Dockerfile                    - Imagen PHP 7.3/Nginx
✓ docker-compose.yml            - Orquestación de servicios (PHP + MySQL)
✓ .dockerignore                 - Archivos excluidos del build
✓ .env.example                  - Variables de entorno (plantilla)
```

### Configuración de Servicios
```
✓ docker/nginx/000-default.conf    - VirtualHost Nginx
✓ docker/php/php.ini                - Configuración PHP 7.3
✓ docker/mysql/init/.gitkeep        - Directorio para scripts SQL
```

### Scripts y Ayudas
```
✓ docker.sh                     - Script bash con comandos útiles
✓ Makefile                      - Alternativa con make (Linux/Mac)
✓ DOCKER.md                     - Documentación completa
✓ DOCKER_MIGRACION.md           - Guía de migración y actualización
```

### Configuración de Base de Datos
```
✓ usuariosConfig/BBDD/MySQL/configMySQL.php      - Config con variables de entorno
✓ usuariosConfig/BBDD/MySQL/conexionMySQL.php    - Función conexión PDO
```

---

## 🚀 Inicio Rápido (3 pasos)

### 1️⃣ Preparar variables de entorno
```bash
cp .env.example .env
```

### 2️⃣ Iniciar Docker
```bash
docker-compose up -d
```

### 3️⃣ Acceder a la aplicación
```
http://localhost:8080
```

**¡Listo!** La aplicación está corriendo con PHP 7.3 + Nginx + MariaDB 10.5

---

## 📋 Servicios Incluidos

| Servicio | Versión | Puerto | Acceso |
|----------|---------|--------|--------|
| **PHP** | 7.3 | - | http://localhost:8080 |
| **Nginx** | 2.4 | 8080 | http://optiplex-790:8080 |
| **MariaDB** | 10.5 | 3306 | `optiplex-790:3306` |

---

## 🛠️ Comandos Útiles

### Opción 1: Usar script bash
```bash
./docker.sh start       # Iniciar
./docker.sh logs        # Ver logs
./docker.sh bash        # Terminal en PHP
./docker.sh mysql       # Conectar a MySQL
./docker.sh db-backup   # Backup de BD
./docker.sh help        # Ver más comandos
```

### Opción 2: Usar make (Linux/Mac)
```bash
make start              # Iniciar
make logs               # Ver logs
make bash               # Terminal en PHP
make mysql              # Conectar a MySQL
make backup             # Backup de BD
make help               # Ver más comandos
```

### Opción 3: Usar docker-compose directamente
```bash
docker-compose up -d
docker-compose logs -f
docker-compose ps
docker-compose down
```

---

## 📁 Estructura del Proyecto

```
├── Dockerfile                          # Imagen Docker
├── docker-compose.yml                  # Orquestación
├── docker.sh                           # Script auxiliar bash
├── Makefile                            # Script make
├── .dockerignore
├── .env.example
├── DOCKER.md                           # Documentación principal
├── DOCKER_MIGRACION.md                 # Guía actualización
│
├── docker/
│   ├── nginx/
│   │   └── 000-default.conf           # Config Nginx
│   ├── php/
│   │   └── php.ini                    # Config PHP
│   └── mysql/
│       └── init/                      # Scripts SQL iniciales
│
├── usuariosConfig/
│   └── BBDD/MySQL/
│       ├── configMySQL.php            # ✨ ACTUALIZADO
│       └── conexionMySQL.php          # ✨ ACTUALIZADO
│
├── controladores/                     # Tu código PHP
├── modelos/                           # Tu código PHP
├── vistas/                            # Vistas
├── index.php                          # Punto de entrada
└── ...
```

---

## 🔧 Configuración Incluida

### PHP 7.3.21
- ✅ Módulos: `mysqli`, `PDO`, `PDO_MySQL`, `GD`
- ✅ Max upload: 50 MB
- ✅ Max execution: 300 segundos
- ✅ Memory: 256 MB
- ✅ Timezone: `Europe/Madrid`

### Nginx 2.4
- ✅ Módulo `rewrite` habilitado
- ✅ Protección de directorios: `/controladores/`, `/modelos/`
- ✅ Soporte para reescrituras de URL
- ✅ VirtualHost configurado

### MariaDB 10.5
- ✅ Database automática: `usuarios`
- ✅ Usuario: `gsh_user`
- ✅ Character set: `utf8mb4`
- ✅ Datos persistentes en volumen

---

## 📊 Variables de Entorno

En `.env` puedes configurar:

```env
# Base de Datos
MYSQL_ROOT_PASSWORD=root           # Contraseña root (cambiar en producción)
MYSQL_DATABASE=gsh            # Nombre BD
MYSQL_USER=gsh_user           # Usuario BD
MYSQL_PASSWORD=gsh_pass       # Contraseña usuario (cambiar en producción)

# Aplicación
DB_HOST=db                         # Host (no cambiar)
DB_PORT=3306                       # Puerto MySQL
APP_PORT=8080                      # Puerto de acceso
```

**⚠️ IMPORTANTE PARA PRODUCCIÓN**: 
- Cambiar `MYSQL_ROOT_PASSWORD` y `MYSQL_PASSWORD`
- NO hacer commit de `.env` a Git

---

## 🔄 Flujo de Trabajo

### Desarrollo
```bash
# 1. Iniciar una sola vez
./docker.sh start

# 2. Editar código (cambios automáticos)
# Los archivos PHP se actualizan en tiempo real

# 3. Ver logs si hay problemas
./docker.sh logs

# 4. Cuando termines
./docker.sh stop
```

### Si cambias Dockerfile o dependencias
```bash
./docker.sh rebuild   # Reconstruir sin caché
./docker.sh restart   # Reiniciar servicios
```

---

## 💾 Base de Datos

### Restaurar desde dump existente
```bash
# Opción 1: Automático (al iniciar)
cp tu_dump.sql docker/mysql/init/01_gsh.sql
./docker.sh down && ./docker.sh start

# Opción 2: Manual después de iniciar
./docker.sh db-restore tu_dump.sql
```

### Hacer backup
```bash
./docker.sh db-backup
# Crea archivo: backup_usuarios_YYYYMMDD_HHMMSS.sql
```

### Conectar directamente a MySQL
```bash
./docker.sh mysql
# O con make:
make mysql
```

---

## 🔒 Seguridad

### Ya Configurado ✅
- ❌ Acceso directo a `/controladores/` bloqueado
- ❌ Acceso directo a `/modelos/` bloqueado
- ✅ Errores PHP no se muestran (display_errors = 0)
- ✅ Sessions seguras configuradas
- ✅ UTF-8 configurado

### Para Producción
1. Cambiar credenciales en `.env`
2. Usar HTTPS con reverse proxy (nginx)
3. Limitar puertos expuestos
4. Usar secretos de Docker/Kubernetes
5. Implementar backup automático

---

## 🐛 Problemas Comunes

### "Conexión a BD rechazada"
```bash
./docker.sh status              # ¿Está corriendo?
./docker.sh logs-db             # Ver error MySQL
./docker.sh mysql               # Probar conexión manual
```

### "Puerto 8080 en uso"
Editar `docker-compose.yml`:
```yaml
ports:
  - "8081:80"  # Cambiar a otro puerto
```

### "Cambios PHP no aparecen"
```bash
./docker.sh restart   # Reiniciar Nginx
./docker.sh logs      # Ver errores
```

### "La BD está vacía"
```bash
# Restaurar dump
./docker.sh db-restore backup.sql

# O crear tablas manualmente
./docker.sh mysql
> CREATE TABLE ...
```

---

## 📚 Documentación

- **`DOCKER.md`**: Documentación completa y detallada
- **`DOCKER_MIGRACION.md`**: Cambios realizados y guía de migración
- Este archivo: Quick start y referencia

---

## ✨ Qué Sigue

### Próximas acciones recomendadas:

1. **Restaurar BD existente**
   ```bash
   # Si tienes un dump.sql
   ./docker.sh db-restore dump.sql
   ```

2. **Verificar funcionamiento**
   - Acceder a http://optiplex-790:8080
   - Verificar logs si hay errores
   - Probar login y funciones

3. **Adaptar configuración**
   - Si necesitas más memoria: editar `docker/php/php.ini`
   - Si necesitas módulos PHP: editar `Dockerfile`
   - Si necesitas reescrituras: editar `docker/nginx/000-default.conf`

4. **Control de versiones**
   ```bash
   git add Dockerfile docker-compose.yml docker/ .env.example docker.sh Makefile DOCKER.md
   git add usuariosConfig/
   echo ".env" >> .gitignore
   git commit -m "Dockerizar aplicación"
   ```

---

## 📞 Soporte

Para más información:
- Consulta `DOCKER.md` (documentación completa)
- Ejecuta `./docker.sh help` o `make help`
- Ver logs: `./docker.sh logs`
- Revisar errores en contenedores

---

**¡Tu proyecto está listo para Docker!** 🎉

```bash
# Empezar ahora mismo:
cp .env.example .env
./docker.sh start
# ¡Accede a http://optiplex-790:8080!
```
