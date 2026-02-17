# 📚 Índice de Documentación - Docker

Documentación completa para el proyecto GSH (Gestión de Socios) dockerizado.

## 🎯 Por Dónde Empezar

### Si es tu primera vez
1. Lee **[RESUMEN_DOCKERIZACION.md](RESUMEN_DOCKERIZACION.md)** - Resumen ejecutivo (5 min)
2. Lee **[QUICK_REFERENCE.md](QUICK_REFERENCE.md)** - Comandos rápidos (referencia)
3. Ejecuta `./docker.sh start` - Inicia Docker
4. Accede a http://localhost:8080

### Si necesitas instrucciones detalladas
Lee **[DOCKER.md](DOCKER.md)** - Documentación completa y exhaustiva

### Si necesitas configuraciones avanzadas
Lee **[DOCKER_AVANZADO.md](DOCKER_AVANZADO.md)** - Optimización y personalización

### Si necesitas saber qué ha cambiado
Lee **[DOCKER_MIGRACION.md](DOCKER_MIGRACION.md)** - Cambios realizados

---

## 📄 Documentos Principales

### [RESUMEN_DOCKERIZACION.md](RESUMEN_DOCKERIZACION.md)
**Tiempo de lectura**: 10 minutos  
**Para**: Entender qué se ha hecho y conceptos generales

Contiene:
- ✅ Archivos creados
- ✅ Inicio rápido (3 pasos)
- ✅ Servicios incluidos
- ✅ Comandos útiles
- ✅ Estructura del proyecto
- ✅ Qué sigue

**👉 COMIENZA AQUÍ**

---

### [DOCKER.md](DOCKER.md)
**Tiempo de lectura**: 30-45 minutos  
**Para**: Referencia completa y solución de problemas

Contiene:
- 📋 Requisitos previos
- 🚀 Guías detalladas
- 📊 Estructura de contenedores
- 🛠️ Comandos extensos
- 🔧 Configuración detallada
- 🗄️ Gestión de base de datos
- 🔒 Consideraciones de seguridad
- 🐛 Solución de problemas
- 📊 Monitoreo
- 🚢 Despliegue a producción

**👉 REFERENCIA PRINCIPAL**

---

### [QUICK_REFERENCE.md](QUICK_REFERENCE.md)
**Tiempo de lectura**: 5 minutos  
**Para**: Consulta rápida de comandos

Contiene:
- 🚀 Inicio rápido
- 📋 Tabla de comandos frecuentes
- 🆘 Problemas comunes
- ✅ Checklist inicial
- 🌍 URLs de acceso

**👉 REFERENCIA RÁPIDA - Lamina Plastificable**

---

### [DOCKER_MIGRACION.md](DOCKER_MIGRACION.md)
**Tiempo de lectura**: 15 minutos  
**Para**: Entender cambios realizados

Contiene:
- 🔄 Cambios en la aplicación
- 📝 Archivos modificados
- 💻 Cómo usar en desarrollo
- 🔧 Estructura de volúmenes
- 🐛 Troubleshooting

**👉 Lee esto si necesitas saber QUÉ cambió**

---

### [DOCKER_AVANZADO.md](DOCKER_AVANZADO.md)
**Tiempo de lectura**: 45 minutos  
**Para**: Configuraciones personalizadas

Contiene:
- 🔧 Personalización de PHP
- 🔄 Base de datos avanzada
- 🌐 Nginx avanzado
- 📊 Monitoreo y logs
- 🚀 Optimización
- 🔒 Seguridad avanzada
- 🐛 Debug remoto
- 📦 Integración CI/CD

**👉 Lee esto para personalizar Docker**

---

## 🛠️ Scripts Incluidos

### [docker.sh](docker.sh)
Script bash con comandos Docker útiles

```bash
./docker.sh start          # Iniciar
./docker.sh stop           # Detener
./docker.sh bash           # Terminal
./docker.sh logs           # Ver logs
./docker.sh mysql          # MySQL client
./docker.sh help           # Ver todos los comandos
```

### [Makefile](Makefile)
Alternativa usando `make` (Linux/Mac)

```bash
make start
make logs
make bash
make help
```

### [verificar-docker.sh](verificar-docker.sh)
Verifica que todo esté configurado correctamente

```bash
./verificar-docker.sh
```

---

## 📦 Archivos Docker Creados

```
Dockerfile                      ✅ Imagen PHP 7.3/Nginx
docker-compose.yml              ✅ Orquestación de servicios
.dockerignore                   ✅ Exclusiones en build
.env.example                    ✅ Variables de entorno (plantilla)

docker/
├── nginx/
│   └── 000-default.conf        ✅ VirtualHost Nginx
├── php/
│   └── php.ini                 ✅ Configuración PHP
└── mysql/
    └── init/                   ✅ Scripts SQL iniciales
```

---

## 🔄 Configuración Actualizada

```
usuariosConfig/
└── BBDD/MySQL/
    ├── configMySQL.php         ✅ Con variables de entorno
    └── conexionMySQL.php       ✅ Función conexión PDO mejorada
```

---

## 📚 Cómo Navegar

### Si estás en Linux/Mac
```bash
# Ver documentación en terminal
cat RESUMEN_DOCKERIZACION.md
cat DOCKER.md | less

# O abrir en editor
code DOCKER.md
nano QUICK_REFERENCE.md
```

### Si estás en Windows
```bash
# Con VS Code
code DOCKER.md

# O abre en tu editor favorito
DOCKER.md
QUICK_REFERENCE.md
```

---

## ✅ Checklist de Lectura Recomendada

- [ ] 1. Lee **RESUMEN_DOCKERIZACION.md** (conceptos generales)
- [ ] 2. Lee **QUICK_REFERENCE.md** (comandos rápidos)
- [ ] 3. Ejecuta verificación: `./verificar-docker.sh`
- [ ] 4. Ejecuta: `./docker.sh start`
- [ ] 5. Accede a: http://optiplex-790:8080
- [ ] 6. Lee **DOCKER_MIGRACION.md** (cambios específicos)
- [ ] 7. Siempre disponible: **DOCKER.md** (referencia completa)
- [ ] 8. Si necesitas: **DOCKER_AVANZADO.md** (personalizaciones)

---

## 🎓 Estructura de Aprendizaje

```
Básico
  ↓
  ├─→ RESUMEN_DOCKERIZACION.md
  ├─→ QUICK_REFERENCE.md
  └─→ ./docker.sh help
      ↓
Intermedio
  ├─→ DOCKER.md
  ├─→ DOCKER_MIGRACION.md
  └─→ Práctica: ./docker.sh start/logs/bash
      ↓
Avanzado
  ├─→ DOCKER_AVANZADO.md
  ├─→ Personalizar Dockerfile
  ├─→ Agregar extensiones PHP
  └─→ Configurar CI/CD
      ↓
Producción
  └─→ Revisar sección "Despliegue a Producción" en DOCKER.md
```

---

## 🔍 Búsqueda Rápida de Temas

| Tema | Documento |
|------|-----------|
| **Inicio rápido** | RESUMEN_DOCKERIZACION.md |
| **Comandos** | QUICK_REFERENCE.md o docker.sh help |
| **Referencia completa** | DOCKER.md |
| **Cambios realizados** | DOCKER_MIGRACION.md |
| **PHP personalizado** | DOCKER_AVANZADO.md |
| **MySQL avanzado** | DOCKER_AVANZADO.md |
| **HTTPS/SSL** | DOCKER_AVANZADO.md |
| **CI/CD** | DOCKER_AVANZADO.md |
| **Producción** | DOCKER.md (Despliegue a Producción) |
| **Problemas** | DOCKER.md (Solución de Problemas) |
| **Seguridad** | DOCKER.md + DOCKER_AVANZADO.md |

---

## 💬 Preguntas Frecuentes por Documento

### ¿Por dónde empiezo?
→ **RESUMEN_DOCKERIZACION.md**

### ¿Cómo inicio Docker?
→ **QUICK_REFERENCE.md** o ejecuta `./docker.sh start`

### ¿Cuáles son todos los comandos?
→ **QUICK_REFERENCE.md** o ejecuta `./docker.sh help`

### ¿Qué archivos han cambiado?
→ **DOCKER_MIGRACION.md**

### ¿Cómo soluciono problemas?
→ **DOCKER.md** - Sección "Solución de Problemas"

### ¿Cómo persisto mi base de datos?
→ **DOCKER.md** - Sección "Base de Datos"

### ¿Cómo hago backup?
→ `./docker.sh db-backup` o **QUICK_REFERENCE.md**

### ¿Cómo agrego extensiones PHP?
→ **DOCKER_AVANZADO.md** - Sección "Personalización de PHP"

### ¿Cómo lo despliego a producción?
→ **DOCKER.md** - Sección "Despliegue a Producción"

---

## 📞 Soporte Rápido

```bash
# Ver documentación
./docker.sh help

# Verificar configuración
./verificar-docker.sh

# Ver logs
./docker.sh logs

# Ejecutar terminal
./docker.sh bash
```

---

## 🗂️ Todas las Documentos

| Archivo | Descripción |
|---------|-------------|
| [RESUMEN_DOCKERIZACION.md](RESUMEN_DOCKERIZACION.md) | Resumen ejecutivo y inicio rápido |
| [DOCKER.md](DOCKER.md) | Documentación principal y completa |
| [QUICK_REFERENCE.md](QUICK_REFERENCE.md) | Guía rápida de comandos |
| [DOCKER_MIGRACION.md](DOCKER_MIGRACION.md) | Cambios realizados y cómo usar |
| [DOCKER_AVANZADO.md](DOCKER_AVANZADO.md) | Configuraciones avanzadas |
| **INDICE.md** | Este archivo (navegación) |

---

**¿Necesitas ayuda?** Consulta el documento correspondiente arriba o ejecuta:
```bash
./docker.sh help
./verificar-docker.sh
./docker.sh logs
```

**¡Disfruta desarrollando con Docker!** 🐳
