# GSH - Gestión de Socios

Sistema de gestión heredada de socios desarrollado en PHP 7.3 con arquitectura MVC.

## 🚀 Características

- **Gestión de Socios**: Alta, baja, modificación y consulta de socios
- **Gestión de Cuotas**: Control de pagos y remesas
- **Roles y Permisos**: Sistema multi-rol (Admin, Tesorero, Presidente, Coordinador, etc.)
- **Notificaciones por Email**: Sistema automatizado de envío de emails
- **Gestión de Bancos**: Integración con sistemas bancarios y PayPal
- **Dockerizado**: Configuración completa con Docker Compose

## 📋 Requisitos

- Docker 20.10+
- Docker Compose 2.0+
- 2GB RAM mínimo
- Puertos libres: 8080 (web), 3306 (MySQL)

## 🔧 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/PepeluiMoreno/GHS.git
cd GHS
```

### 2. Configurar variables de entorno

```bash
cp .env.example .env
# Editar .env con tus configuraciones
```

### 3. Iniciar con Docker

```bash
docker compose up -d
```

O usando el script auxiliar:

```bash
./docker.sh start
```

### 4. Acceder a la aplicación

```
http://localhost:8080
```

## 📖 Documentación

- **[INDICE.md](INDICE.md)** - Índice completo de documentación
- **[QUICK_REFERENCE.md](QUICK_REFERENCE.md)** - Referencia rápida de comandos
- **[DOCKER.md](DOCKER.md)** - Documentación detallada de Docker
- **[RESUMEN_DOCKERIZACION.md](RESUMEN_DOCKERIZACION.md)** - Resumen de la dockerización

## 🗂️ Estructura del Proyecto

```
gsh/
├── controladores/          # Controladores MVC
├── modelos/               # Modelos y lógica de negocio
├── vistas/                # Vistas (HTML/PHP)
├── docker/                # Configuración Docker
│   ├── nginx/            # Configuración Nginx
│   ├── php/              # Configuración PHP
│   └── mysql/            # Scripts inicialización MySQL
├── docker-compose.yml     # Orquestación de servicios
├── Dockerfile             # Imagen PHP-FPM
└── docker.sh              # Script auxiliar
```

## 🐳 Servicios Docker

| Servicio | Contenedor | Puerto | Descripción |
|----------|-----------|--------|-------------|
| PHP-FPM  | gsh_app   | 9000   | Aplicación PHP 7.3 |
| Nginx    | gsh_nginx | 8080   | Servidor web |
| MariaDB  | gsh_db    | 3306   | Base de datos |

## 🛠️ Comandos Útiles

```bash
# Iniciar servicios
./docker.sh start

# Ver logs
./docker.sh logs

# Detener servicios
./docker.sh stop

# Reconstruir contenedores
./docker.sh rebuild

# Acceder a la base de datos
docker compose exec db mysql -u gsh_user -pgsh_pass gsh

# Ver estado de contenedores
docker compose ps
```

## 🔐 Configuración por Defecto

**Base de Datos:**
- Database: `gsh`
- Usuario: `gsh_user`
- Password: `gsh_pass`
- Root Password: `root`

⚠️ **Cambiar estas credenciales en producción**

## 📝 Variables de Entorno

Edita el archivo `.env` para personalizar:

- `MYSQL_DATABASE` - Nombre de la base de datos
- `MYSQL_USER` - Usuario de MySQL
- `MYSQL_PASSWORD` - Contraseña de MySQL
- `APP_PORT` - Puerto de la aplicación web (default: 8080)
- `DB_PORT` - Puerto de MySQL (default: 3306)

##  Licencia

Proyecto privado de uso interno exclusivo de la organización.

## 👥 Desarrollo y Mantenimiento

Desarrollo y mantenimiento por el equipo técnico interno.

---

**Última actualización**: 17 de febrero de 2026
