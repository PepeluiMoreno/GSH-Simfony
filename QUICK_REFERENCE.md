# QUICK REFERENCE - Comandos Docker

## 🚀 Inicio Rápido

```bash
# Copiar configuración
cp .env.example .env

# Iniciar
docker-compose up -d

# Ver estado
docker-compose ps

# Acceder a la aplicación
# http://localhost:8080
```

---

## 📋 Comandos Frecuentes

### Inicio / Parada

| Comando | Descripción |
|---------|-------------|
| `./docker.sh start` | Iniciar contenedores |
| `./docker.sh stop` | Detener contenedores |
| `./docker.sh restart` | Reiniciar contenedores |
| `./docker.sh down` | Detener y eliminar |
| `./docker.sh status` | Ver estado |

### Logs y Debug

| Comando | Descripción |
|---------|-------------|
| `./docker.sh logs` | Ver todos los logs |
| `./docker.sh logs-app` | Logs del PHP/Nginx |
| `./docker.sh logs-db` | Logs de MySQL |
| `./docker.sh bash` | Terminal en PHP |
| `./docker.sh bash-db` | Terminal de MySQL |

### Base de Datos

| Comando | Descripción |
|---------|-------------|
| `./docker.sh mysql` | Conectar a MySQL |
| `./docker.sh db-backup` | Hacer backup |
| `./docker.sh db-restore archivo.sql` | Restaurar backup |
| `./docker.sh dump archivo.sql` | Exportar BD |

### Construcción

| Comando | Descripción |
|---------|-------------|
| `./docker.sh build` | Construir imagen |
| `./docker.sh rebuild` | Reconstruir sin caché |

---

## 🔧 Usando Make (Linux/Mac)

```bash
make start          # Iniciar
make stop           # Detener
make restart        # Reiniciar
make logs           # Ver logs
make bash           # Terminal PHP
make mysql          # Terminal MySQL
make backup         # Backup BD
make restore FILE=backup.sql  # Restaurar
make help           # Ver todos los comandos
```

---

## 📦 Docker Compose Directo

```bash
# Iniciar en background
docker-compose up -d

# Ver logs
docker-compose logs -f

# Ejecutar comando en PHP
docker-compose exec app bash
docker-compose exec app php -v

# Conectar a MySQL
docker-compose exec db mysql -u gsh_user -pgsh_pass gsh

# Backup
docker-compose exec -T db mysqldump -u gsh_user -pgsh_pass gsh > backup.sql

# Detener
docker-compose down
```

---

## 📁 Archivos Importantes

```
Dockerfile                  # Imagen PHP/Nginx
docker-compose.yml          # Configuración servicios
.env.example                # Variables (ejemplo)
.env                        # Variables activas (crear con 'cp .env.example .env')

docker/
├── nginx/000-default.conf # Config Nginx
├── php/php.ini             # Config PHP
└── mysql/init/             # Scripts SQL

DOCKER.md                   # Documentación completa
DOCKER_MIGRACION.md         # Cambios realizados
DOCKER_AVANZADO.md          # Configuraciones avanzadas
```

---

## 🆘 Problemas Comunes

### "Puerto 8080 en uso"
Editar `docker-compose.yml`:
```yaml
ports:
  - "8081:80"  # Cambiar puerto
```

### "No puedo conectar a la BD"
```bash
./docker.sh logs-db          # Ver error
./docker.sh mysql            # Probar conexión
./docker.sh status           # Verificar que esté corriendo
```

### "Cambios PHP no aparecen"
```bash
./docker.sh restart          # Reiniciar Nginx
./docker.sh logs-app         # Ver errores
```

### "Llevar datos de BD"
```bash
cp tu_dump.sql docker/mysql/init/01_gsh.sql
./docker.sh down && ./docker.sh start
```

---

## ✅ Verificación

```bash
# Verificar que todo está configurado
./verificar-docker.sh

# Debería mostrar todos los checks en verde ✓
```

---

## 🌍 Acceso

| Servicio | URL/Puerto |
|----------|-----------|
| Aplicación | http://optiplex-790:8080 |
| MySQL | optiplex-790:3306 |
| Usuario MySQL | `gsh_user` |
| Contraseña BD | Ver en `.env` |

---

## 💾 Variables de Entorno (.env)

```env
MYSQL_ROOT_PASSWORD=root           # Contraseña root
MYSQL_DATABASE=gsh            # Nombre BD
MYSQL_USER=gsh_user           # Usuario BD
MYSQL_PASSWORD=gsh_pass       # Contraseña usuario
DB_HOST=db                         # Host (no cambiar)
DB_PORT=3306                       # Puerto MySQL
```

**⚠️ Para producción**: Cambiar contraseñas y NO hacer commit de `.env`

---

## 📊 Monitoreo

```bash
# Ver uso de recursos
docker stats

# Ver eventos
docker events

# Ver detalles de contenedor
docker-compose ps --no-trunc
docker inspect gsh_app
docker inspect gsh_db

# Ver IP del contenedor
docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' gsh_app
```

---

## 🔄 Development Workflow

```bash
# 1. Iniciar (una sola vez)
./docker.sh start

# 2. Ver logs mientras trabajas
./docker.sh logs

# 3. Editar PHP/HTML/CSS (cambios en vivo)
# Editar archivos normalmente

# 4. Si necesitas PHP/MySQL
./docker.sh bash           # Terminal PHP
./docker.sh mysql          # Terminal MySQL

# 5. Si reconstruyes Dockerfile
./docker.sh rebuild && ./docker.sh restart

# 6. Al terminar
./docker.sh stop
```

---

## 🎯 Checklist Inicial

- [ ] Instalar Docker y Docker Compose
- [ ] Ejecutar `cp .env.example .env`
- [ ] Ejecutar `./docker.sh start`
- [ ] Acceder a http://optiplex-790:8080
- [ ] Ejecutar `./verificar-docker.sh`
- [ ] Restaurar BD existente (si tienes dump)
- [ ] Probar login y funciones

---

## 📚 Documentación Completa

- `DOCKER.md` - Documentación principal
- `DOCKER_MIGRACION.md` - Cambios y cómo usar
- `DOCKER_AVANZADO.md` - Configuraciones avanzadas
- `RESUMEN_DOCKERIZACION.md` - Resumen completo

---

## 🆘 Soporte

```bash
# Ver toda la ayuda
./docker.sh help
make help

# Ver logs detallados
./docker.sh logs

# Ejecutar verificación
./verificar-docker.sh

# Contactar: Ver DOCKER.md sección Support
```

---

**¡Disfruta desarrollando con Docker!** 🐳
