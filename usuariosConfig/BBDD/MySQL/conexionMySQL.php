<?php
/*------------------------------------------------------------------------------
FICHERO: conexionMySQL.php
DESCRIPCION: Establece la conexión a la base de datos MySQL/MariaDB
             Utiliza PDO para máxima compatibilidad
------------------------------------------------------------------------------*/

function conexionDB($serverDB, $usernameDB, $passwordDB, $esquemaDB, $puertoDBMySQL = '3306')
{
    $arrConexionDB = array();
    $arrConexionDB['codError'] = "00000";
    $arrConexionDB['errorMensaje'] = "";
    
    try {
        // Crear DSN para PDO
        $dsn = "mysql:host={$serverDB};port={$puertoDBMySQL};dbname={$esquemaDB};charset=utf8mb4";
        
        // Opciones de conexión
        $opciones = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4, sql_mode='STRICT_TRANS_TABLES'"
        );
        
        // Crear conexión
        $conexionLink = new PDO($dsn, $usernameDB, $passwordDB, $opciones);
        
        $arrConexionDB['conexionLink'] = $conexionLink;
        
    } catch (PDOException $e) {
        $arrConexionDB['codError'] = "9999";
        $arrConexionDB['errorMensaje'] = "Error de conexión a Base de Datos: " . $e->getMessage();
    } catch (Exception $e) {
        $arrConexionDB['codError'] = "9998";
        $arrConexionDB['errorMensaje'] = "Error no previsto: " . $e->getMessage();
    }
    
    return $arrConexionDB;
}

?>
