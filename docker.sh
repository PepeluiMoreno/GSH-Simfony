#!/bin/bash

# Script auxiliar para gestión de Docker en el proyecto usuarios
# Uso: ./docker.sh [comando]

set -e

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Función para imprimir con color
print_header() {
    echo -e "${BLUE}▶ $1${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

# Función para mostrar ayuda
show_help() {
    cat << EOF
${BLUE}╔════════════════════════════════════════════════════════════╗${NC}
${BLUE}║  Script auxiliar para Docker - Aplicación Usuarios         ║${NC}
${BLUE}╚════════════════════════════════════════════════════════════╝${NC}

${GREEN}Comandos disponibles:${NC}

  ${YELLOW}start${NC}          Iniciar contenedores (docker-compose up -d)
  ${YELLOW}stop${NC}           Detener contenedores (docker-compose stop)
  ${YELLOW}restart${NC}        Reiniciar contenedores
  ${YELLOW}down${NC}           Detener y eliminar contenedores
  ${YELLOW}build${NC}          Construir imagen de Docker
  ${YELLOW}rebuild${NC}        Reconstruir imagen sin caché
  ${YELLOW}status${NC}         Ver estado de los contenedores
  ${YELLOW}logs${NC}           Ver logs en tiempo real (Ctrl+C para salir)
  ${YELLOW}logs-app${NC}       Ver logs solo del contenedor app
  ${YELLOW}logs-db${NC}        Ver logs solo del contenedor db
  ${YELLOW}bash${NC}           Abrir terminal bash en contenedor app
  ${YELLOW}bash-db${NC}        Abrir terminal mysql en contenedor db
  ${YELLOW}php${NC}            Ejecutar comando PHP en contenedor
  ${YELLOW}composer${NC}       Ejecutar composer (si aplica)
  ${YELLOW}db-backup${NC}      Hacer backup de la base de datos
  ${YELLOW}db-restore${NC}     Restaurar base de datos desde backup
  ${YELLOW}dump${NC}           Descargar dump de la base de datos en SQL
  ${YELLOW}mysql${NC}          Conectarse a MySQL con cliente
  ${YELLOW}clean${NC}          Limpiar volúmenes y contenedores
  ${YELLOW}reset${NC}          Reset completo (elimina datos de BD)
  ${YELLOW}help${NC}           Mostrar esta ayuda

${GREEN}Ejemplos:${NC}

  ${YELLOW}./docker.sh start${NC}
  ${YELLOW}./docker.sh logs -f${NC}
  ${YELLOW}./docker.sh bash${NC}
  ${YELLOW}./docker.sh php bin/console${NC}

EOF
}

# Comando: start
cmd_start() {
    print_header "Iniciando contenedores..."
    docker-compose up -d
    print_success "Contenedores iniciados"
    docker-compose ps
}

# Comando: stop
cmd_stop() {
    print_header "Deteniendo contenedores..."
    docker-compose stop
    print_success "Contenedores detenidos"
}

# Comando: restart
cmd_restart() {
    print_header "Reiniciando contenedores..."
    docker-compose restart
    print_success "Contenedores reiniciados"
    docker-compose ps
}

# Comando: down
cmd_down() {
    print_header "Deteniendo y eliminando contenedores..."
    docker-compose down
    print_success "Contenedores eliminados"
}

# Comando: build
cmd_build() {
    print_header "Construyendo imagen Docker..."
    docker-compose build
    print_success "Imagen construida"
}

# Comando: rebuild
cmd_rebuild() {
    print_header "Reconstruyendo imagen (sin caché)..."
    docker-compose build --no-cache
    print_success "Imagen reconstruida"
}

# Comando: status
cmd_status() {
    print_header "Estado de los contenedores:"
    docker-compose ps
}

# Comando: logs
cmd_logs() {
    print_header "Mostrando logs de todos los servicios..."
    docker-compose logs -f
}

# Comando: logs-app
cmd_logs_app() {
    print_header "Mostrando logs del contenedor app..."
    docker-compose logs -f app
}

# Comando: logs-db
cmd_logs_db() {
    print_header "Mostrando logs del contenedor db..."
    docker-compose logs -f db
}

# Comando: bash
cmd_bash() {
    print_header "Abriendo bash en contenedor app..."
    docker-compose exec app bash
}

# Comando: bash-db
cmd_bash_db() {
    print_header "Conectando a MySQL..."
    docker-compose exec db mysql -u usuarios_user -pusuarios_pass usuarios
}

# Comando: php
cmd_php() {
    print_header "Ejecutando PHP..."
    shift
    docker-compose exec app php "$@"
}

# Comando: db-backup
cmd_db_backup() {
    BACKUP_FILE="backup_usuarios_$(date +%Y%m%d_%H%M%S).sql"
    print_header "Creando backup de base de datos: $BACKUP_FILE"
    docker-compose exec -T db mysqldump -u usuarios_user -pusuarios_pass usuarios > "$BACKUP_FILE"
    print_success "Backup creado: $BACKUP_FILE"
}

# Comando: db-restore
cmd_db_restore() {
    if [ -z "$2" ]; then
        print_error "Uso: ./docker.sh db-restore archivo.sql"
        exit 1
    fi
    print_header "Restaurando base de datos desde: $2"
    docker-compose exec -T db mysql -u usuarios_user -pusuarios_pass usuarios < "$2"
    print_success "Base de datos restaurada"
}

# Comando: dump
cmd_dump() {
    OUTPUT_FILE="${2:-usuarios_$(date +%Y%m%d_%H%M%S).sql}"
    print_header "Descargando dump SQL a: $OUTPUT_FILE"
    docker-compose exec -T db mysqldump -u usuarios_user -pusuarios_pass usuarios > "$OUTPUT_FILE"
    print_success "Dump descargado: $OUTPUT_FILE"
}

# Comando: mysql
cmd_mysql() {
    print_header "Conectando a MySQL..."
    docker-compose exec db mysql -u usuarios_user -pusuarios_pass usuarios
}

# Comando: clean
cmd_clean() {
    print_warning "Eliminando volúmenes y contenedores (sin eliminar datos de BD)..."
    read -p "¿Estás seguro? (s/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Ss]$ ]]; then
        docker-compose down -v
        print_success "Limpieza completada"
    else
        print_warning "Operación cancelada"
    fi
}

# Comando: reset
cmd_reset() {
    print_warning "RESET COMPLETO - Esto eliminará TODA la base de datos"
    read -p "¿Estás REALMENTE seguro? Escribe 'sí' para continuar: " -r
    if [[ $REPLY == "sí" ]]; then
        docker-compose down -v --rmi all
        print_success "Reset completado - Todos los datos han sido eliminados"
    else
        print_warning "Operación cancelada"
    fi
}

# Comando principal
main() {
    local cmd="${1:-help}"
    
    case "${cmd}" in
        start)          cmd_start ;;
        stop)           cmd_stop ;;
        restart)        cmd_restart ;;
        down)           cmd_down ;;
        build)          cmd_build ;;
        rebuild)        cmd_rebuild ;;
        status)         cmd_status ;;
        logs)           cmd_logs ;;
        logs-app)       cmd_logs_app ;;
        logs-db)        cmd_logs_db ;;
        bash)           cmd_bash ;;
        bash-db)        cmd_bash_db ;;
        php)            cmd_php "$@" ;;
        db-backup)      cmd_db_backup ;;
        db-restore)     cmd_db_restore "$@" ;;
        dump)           cmd_dump "$@" ;;
        mysql)          cmd_mysql ;;
        clean)          cmd_clean ;;
        reset)          cmd_reset ;;
        help)           show_help ;;
        *)              print_error "Comando desconocido: $cmd"; show_help; exit 1 ;;
    esac
}

main "$@"
