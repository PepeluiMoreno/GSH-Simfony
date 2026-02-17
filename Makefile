.PHONY: help start stop restart logs bash mysql build clean

# Variables por defecto
DOCKER_COMPOSE := docker-compose
PHP_CONTAINER := usuarios_app
DB_CONTAINER := usuarios_db

help: ## Mostrar esta ayuda
	@echo "╔════════════════════════════════════════════╗"
	@echo "║  Makefile - Proyecto Usuarios con Docker   ║"
	@echo "╚════════════════════════════════════════════╝"
	@echo ""
	@echo "Comandos disponibles:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'
	@echo ""
	@echo "Ejemplos:"
	@echo "  make start      # Iniciar contenedores"
	@echo "  make logs       # Ver logs en tiempo real"
	@echo "  make bash       # Abrir terminal en PHP"
	@echo ""

start: ## Iniciar contenedores (docker-compose up -d)
	@echo "▶ Iniciando contenedores..."
	$(DOCKER_COMPOSE) up -d
	@$(DOCKER_COMPOSE) ps
	@echo "✓ Abierto en: http://optiplex-790:8080"

stop: ## Detener contenedores
	@echo "▶ Deteniendo contenedores..."
	$(DOCKER_COMPOSE) stop

restart: ## Reiniciar contenedores
	@echo "▶ Reiniciando contenedores..."
	$(DOCKER_COMPOSE) restart
	@$(DOCKER_COMPOSE) ps

down: ## Detener y eliminar contenedores
	@echo "▶ Deteniendo y eliminando contenedores..."
	$(DOCKER_COMPOSE) down

build: ## Construir imagen Docker
	@echo "▶ Construyendo imagen..."
	$(DOCKER_COMPOSE) build

rebuild: ## Reconstruir sin caché
	@echo "▶ Reconstruyendo imagen (sin caché)..."
	$(DOCKER_COMPOSE) build --no-cache

status: ## Ver estado de contenedores
	$(DOCKER_COMPOSE) ps

logs: ## Ver logs en tiempo real
	$(DOCKER_COMPOSE) logs -f

logs-app: ## Ver logs del contenedor PHP
	$(DOCKER_COMPOSE) logs -f app

logs-db: ## Ver logs del contenedor MySQL
	$(DOCKER_COMPOSE) logs -f db

bash: ## Abrir bash en contenedor PHP
	$(DOCKER_COMPOSE) exec app bash

bash-db: ## Conectar a MySQL
	$(DOCKER_COMPOSE) exec db mysql -u usuarios_user -pusuarios_pass usuarios

php: ## Ejecutar comando PHP (ej: make php ARGS="--version")
	$(DOCKER_COMPOSE) exec app php $(ARGS)

backup: ## Hacer backup de la base de datos
	@echo "▶ Creando backup..."
	@docker-compose exec -T db mysqldump -u usuarios_user -pusuarios_pass usuarios > backup_usuarios_$(shell date +\%Y\%m\%d_\%H\%M\%S).sql
	@echo "✓ Backup creado"

restore: ## Restaurar base de datos (ej: make restore FILE=backup.sql)
	@if [ -z "$(FILE)" ]; then \
		echo "✗ Uso: make restore FILE=archivo.sql"; \
		exit 1; \
	fi
	$(DOCKER_COMPOSE) exec -T db mysql -u usuarios_user -pusuarios_pass usuarios < $(FILE)
	@echo "✓ Base de datos restaurada"

dump: ## Exportar SQL actual (ej: make dump FILE=export.sql)
	@echo "▶ Exportando base de datos..."
	@docker-compose exec -T db mysqldump -u usuarios_user -pusuarios_pass usuarios > $(if $(FILE),$(FILE),usuarios_$(shell date +\%Y\%m\%d_\%H\%M\%S).sql)

clean: ## Limpiar volúmenes
	@echo "⚠ Eliminando volúmenes (BD data NO será eliminada)..."
	$(DOCKER_COMPOSE) down -v
	@echo "✓ Limpieza completada"

reset: ## Reset completo (DESTRUYE DATOS)
	@echo "⚠ RESET COMPLETO - Se eliminarán TODOS los datos"
	@read -p "Escribe 'sí' para confirmar: " confirm; \
	if [ "$$confirm" = "sí" ]; then \
		$(DOCKER_COMPOSE) down -v --rmi all; \
		echo "✓ Reset completado"; \
	else \
		echo "✓ Operación cancelada"; \
	fi

.DEFAULT_GOAL := help
