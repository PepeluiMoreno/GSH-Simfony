# Hands-off: Migración de GSH a Symfony

## Planificación de la migración

1. Preparar entorno Symfony en subcarpeta (symfony/) para mantener separado el legacy del nuevo código.
2. Instalar los paquetes necesarios: symfony/form, symfony/validator, symfony/twig-bundle, symfony/security-csrf, etc.
3. Analizar el formulario y lógica legacy para listar todos los campos, validaciones y dependencias.
4. Crear entidad Socio y DTOs necesarios.
5. Implementar SocioType (FormType) en Symfony.
6. Migrar validaciones y lógica de negocio a servicios Symfony.
7. Crear SocioRepository y adaptar acceso a datos.
8. Migrar controlador de alta de socio a Symfony.
9. Migrar vistas/formularios a Twig.
10. Migrar fragmentos reutilizables a templates/_partials.
11. Adaptar helpers y utilidades a src/Service o src/Utils.
12. Actualizar rutas y configuración Symfony.
13. Probar y verificar equivalencia funcional.

## Progreso realizado


- [x] Migrar función validarCamposAltaSocioSocio (esqueleto y comentarios creados)

---
**Pausa temporal:**
Se ha migrado el esqueleto y comentarios de la función principal de alta de socio en ValidarCamposSocioService. Pendiente migrar la función validarCamposFormAltaSocio y el resto de validaciones y lógica interna.


## TODOs detallados y progreso

- [ ] Terminar migración de ValidarCamposSocioService
- [ ] Completar entidad Socio y SocioRepository
- [ ] Adaptar controlador y flujo de alta completo
- [ ] Migrar y adaptar vistas y fragmentos
- [ ] Probar equivalencia funcional y accesibilidad

- [x] Migrar función validarCamposAltaSocioSocio (esqueleto y comentarios creados)
- [ ] Migrar función validarCamposFormAltaSocio
- [ ] Adaptar validaciones de usuario, email y documento
- [ ] Adaptar validaciones de campos personales y de domicilio
- [ ] Adaptar validaciones de cuota y tipo de socio
- [ ] Integrar comprobaciones de errores y mensajes

_Actualiza esta lista conforme avances en cada sub-tarea._

---

Este documento resume la planificación y el estado actual de la migración de GSH a Symfony. Continúa el desarrollo y la migración en la carpeta y repo GSH-Simfony.
