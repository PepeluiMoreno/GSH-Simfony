-- Script de inicialización: crear usuario y permisos
-- Este script se ejecuta ANTES del dump para asegurar credenciales

-- Crear usuario si no existe
CREATE USER IF NOT EXISTS 'usuarios_user'@'%' IDENTIFIED BY 'usuarios_pass';
CREATE USER IF NOT EXISTS 'usuarios_user'@'localhost' IDENTIFIED BY 'usuarios_pass';

-- Otorgar permisos
GRANT ALL PRIVILEGES ON *.* TO 'usuarios_user'@'%';
GRANT ALL PRIVILEGES ON *.* TO 'usuarios_user'@'localhost';

FLUSH PRIVILEGES;

-- Crear database si no existe
CREATE DATABASE IF NOT EXISTS usuarios CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE usuarios;
