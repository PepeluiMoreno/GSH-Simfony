#!/usr/bin/env php
<?php
require_once __DIR__ . '/../usuariosConfig/email/configEmail.php';

if (!function_exists('getEmailTransportConfig')) {
    fwrite(STDERR, "No email configuration helper available.\n");
    exit(1);
}

$config = getEmailTransportConfig();
if (($config['mode'] ?? 'mail') !== 'smtp') {
    fwrite(STDERR, "MAIL_TRANSPORT is not set to smtp.\n");
    exit(1);
}

$root = realpath(__DIR__ . '/../usuariosLibs/classes/PHPMailer6');
if (!$root) {
    fwrite(STDERR, "PHPMailer6 directory not found in usuariosLibs/classes.\n");
    exit(1);
}

require_once $root . '/src/Exception.php';
require_once $root . '/src/PHPMailer.php';
require_once $root . '/src/SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);
$mail->isSMTP();
$mail->Host = $config['host'];
$mail->Port = (int)($config['port'] ?: 587);
$mail->SMTPAuth = ($config['auth'] === null || $config['auth'] === '') ? ($config['user'] !== '' || $config['password'] !== '') : filter_var($config['auth'], FILTER_VALIDATE_BOOLEAN);
if ($mail->SMTPAuth) {
    $mail->Username = $config['user'];
    $mail->Password = $config['password'];
}
$encryption = strtolower($config['encryption'] ?? '');
if (in_array($encryption, ['tls', 'starttls'], true)) {
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAutoTLS = true;
} elseif (in_array($encryption, ['ssl', 'smtps'], true)) {
    $mail->SMTPSecure = 'ssl';
}
$mail->Timeout = (int)($config['timeout'] ?: 30);

$debugLevel = getenv('SMTP_TEST_DEBUG');
$mail->SMTPDebug = ($debugLevel === false) ? 2 : (int)$debugLevel;
$mail->Debugoutput = static function ($str) {
    $stamp = gmdate('Y-m-d H:i:s');
    echo "[$stamp] $str";
};

$verifyPeer = getenv('SMTP_TEST_VERIFY_PEER');
if ($verifyPeer !== false && $verifyPeer === '0') {
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];
} elseif (!empty($config['verify_peer']) && strtolower($config['verify_peer']) === '0') {
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];
}

try {
    if (!$mail->smtpConnect()) {
        throw new Exception($mail->ErrorInfo ?: 'smtpConnect failed');
    }
    echo "SMTP connection established.\n";

    $testRecipient = getenv('SMTP_TEST_TO');
    if ($testRecipient) {
        $mail->setFrom($config['user'] ?: 'no-reply@example.test', 'SMTP Test');
        $mail->addAddress($testRecipient);
        $mail->Subject = 'SMTP connectivity test';
        $mail->Body = 'Mensaje de prueba enviado por scripts/test_smtp.php';
        if (!$mail->send()) {
            throw new Exception($mail->ErrorInfo ?: 'send failed');
        }
        echo "Test email sent to $testRecipient.\n";
    }

    $mail->smtpClose();
    exit(0);
} catch (Exception $e) {
    fwrite(STDERR, "Error: " . $e->getMessage() . "\n");
    exit(1);
}
