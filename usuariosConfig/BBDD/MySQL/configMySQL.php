<?php
/*------------------------------------------------------------------------------
FICHERO: configMySQL.php
DESCRIPCION: Configuración de conexión a base de datos MySQL/MariaDB
             
NOTAS: Para Docker, estas variables se pueden sobrescribir con variables 
       de entorno del sistema
------------------------------------------------------------------------------*/

// Obtener variables de entorno o usar valores por defecto
$serverDB = getenv('DB_HOST') ?: (getenv('MYSQL_HOST') ?: 'localhost');
$usernameDB = getenv('MYSQL_USER') ?: 'usuarios_user';
$passwordDB = getenv('MYSQL_PASSWORD') ?: 'usuarios_pass';
$esquemaDB = getenv('MYSQL_DATABASE') ?: 'usuarios';
$puertoDBMySQL = getenv('MYSQL_PORT') ?: '3306';

// Configuración de encoding
$charsetDB = 'utf8mb4';

// Opciones de timeout y reconexión
$timeoutDB = 10;
$reconnectDB = true;

// Modo debug (desactivar en producción)
$debugDB = (getenv('DB_DEBUG') ?: false);

?>
