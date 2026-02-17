<?php
/*
 * Utilidades de codificacion Base64 para IDs en URLs.
 */

function encriptarBase64($valor)
{
    return rtrim(strtr(base64_encode((string)$valor), '+/', '-_'), '=');
}

function desEncriptarBase64($valor)
{
    $valor = (string)$valor;
    $padding = strlen($valor) % 4;
    if ($padding > 0) {
        $valor .= str_repeat('=', 4 - $padding);
    }
    $valor = strtr($valor, '-_', '+/');
    return base64_decode($valor);
}
?>
