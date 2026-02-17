docker compose up -d
docker compose ps
# GSH (Gestión de Socios)

Plataforma interna de Europa Laica para administrar el ciclo de vida de simpatizantes y socios, controlar cuotas y coordinar comunicaciones con los distintos roles de la organización.

## Stack Tecnológico

- PHP 7.3 con MVC clásico y PHPMailer 6 para la mensajería transaccional.
- MariaDB 10.5 como base de datos relacional.
- Servicios orquestados con Docker Compose (PHP-FPM, Nginx, MariaDB).
- Nginx sustituye al antiguo Apache por menor consumo de memoria, soporte nativo de FastCGI para PHP-FPM y reglas más sencillas para servir el frontal SPA + formularios heredados, manteniendo compatibilidad con las URLs históricas.

## Funcionalidad Clave

- Alta, baja y modificación de socios, simpatizantes y usuarios internos.
- Gestión financiera: cuotas periódicas, remesas SEPA, conciliación con Pasarela PayPal y alertas de impago.
- Módulos de comunicación: avisos por correo firmados con PHPMailer, plantillas HTML y trazabilidad de envíos.
- Roles de trabajo (Administración, Tesorería, Presidencia, Coordinación, Mantenimiento) con control granular de permisos.
- Integración con el WordPress público de laicismo.org: el formulario de alta expone la captación de usuarios desde la web y sincroniza datos con la base interna.

---

**Última actualización**: 17 de febrero de 2026
