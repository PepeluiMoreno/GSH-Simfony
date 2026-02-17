FROM php:7.3-fpm

# Metadatos
LABEL maintainer="Desarrollo" \
      description="Aplicación PHP 7.3 con PHP-FPM"

# Crear usuario ad-hoc para desarrollo (no root)
RUN useradd -m -s /bin/bash -u 1000 jose

# Instalar dependencias básicas
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Extensiones PHP necesarias para MySQL
RUN docker-php-ext-install mysqli pdo_mysql

# Configurar PHP antes de copiar la aplicación
RUN echo 'include_path = ".:/var/www/html:/usr/local/lib/php"' > /usr/local/etc/php/conf.d/custom.ini && \
    echo 'display_errors = 0' >> /usr/local/etc/php/conf.d/custom.ini && \
    echo 'display_startup_errors = 0' >> /usr/local/etc/php/conf.d/custom.ini && \
    echo 'log_errors = 1' >> /usr/local/etc/php/conf.d/custom.ini && \
    echo 'default_charset = "UTF-8"' >> /usr/local/etc/php/conf.d/custom.ini && \
    echo 'session.save_path = "/var/www/html/tmp"' >> /usr/local/etc/php/conf.d/custom.ini && \
    echo 'session.cookie_httponly = 1' >> /usr/local/etc/php/conf.d/custom.ini && \
    echo 'session.use_strict_mode = 1' >> /usr/local/etc/php/conf.d/custom.ini && \
    echo 'date.timezone = "Europe/Madrid"' >> /usr/local/etc/php/conf.d/custom.ini

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar contenido de la aplicación (código + deps)
COPY --chown=1000:1000 . .

# Crear directorios para archivos subidos y temporales
RUN mkdir -p /var/www/html/archivos /var/www/html/tmp /var/www/html/tmp/emails && \
    chown -R jose:jose /var/www/html && \
    chmod 755 /var/www/html/archivos /var/www/html/tmp

# Establecer permisos apropiados para el usuario jose
RUN chmod -R u+rwX,g+rX,o+rX /var/www/html

# Configurar PHP-FPM para ejecutarse como jose
RUN sed -i 's/www-data/jose/g' /usr/local/etc/php-fpm.d/www.conf

# Mostrar información de PHP
RUN php -v

EXPOSE 9000

# Script de entrada PHP-FPM
ENTRYPOINT ["php-fpm"]
