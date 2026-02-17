<?php
/*------------------------------------------------------------------------------
FICHERO: configEmail.php
DESCRIPCION: Configuración de transporte para el envío de emails.

Permite controlar PHPMailer a través de variables de entorno. Si no se define
ninguna variable, mantiene el comportamiento por defecto (mail()).
------------------------------------------------------------------------------*/

if (!function_exists('getEmailTransportConfig')) {
    /**
     * Obtiene la configuración de transporte a partir de variables de entorno.
     *
     * @return array
     */
    function getEmailTransportConfig()
    {
        static $config;

        if ($config === null) {
            $mode = getenv('MAIL_TRANSPORT') ?: 'mail';
            $mode = strtolower($mode);
            $mode = in_array($mode, ['smtp', 'sendmail', 'mail'], true) ? $mode : 'mail';

            $config = [
                'mode'          => $mode,
                'host'          => trim((string) (getenv('SMTP_HOST') ?: '')),
                'port'          => trim((string) (getenv('SMTP_PORT') ?: '')),
                'user'          => trim((string) (getenv('SMTP_USERNAME') ?: getenv('SMTP_USER') ?: '')),
                'password'      => (string) (getenv('SMTP_PASSWORD') ?: ''),
                'encryption'    => trim((string) (getenv('SMTP_ENCRYPTION') ?: '')),
                'auth'          => getenv('SMTP_AUTH'),
                'debug'         => trim((string) (getenv('SMTP_DEBUG') ?: '0')),
                'timeout'       => trim((string) (getenv('SMTP_TIMEOUT') ?: '')),
                'sendmail_path' => trim((string) (getenv('SENDMAIL_PATH') ?: '')),
                'verify_peer'   => trim((string) (getenv('SMTP_VERIFY_PEER') ?: '')),
            ];
        }

        return $config;
    }
}

?>
