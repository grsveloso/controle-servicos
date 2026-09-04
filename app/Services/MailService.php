<?php

class MailService
{
    private const SMTP_HOST = 'smtp.gmail.com';
    private const SMTP_PORT = 587;

    private const SMTP_USERNAME = 'titansoftware@gmail.com';
    private const SMTP_PASSWORD = 'abcd efgh ijkl mnop';

    public static function sendServiceFinishedEmail($toEmail, $toName, $description, $price)
    {
        $subject = 'Serviço Finalizado - Titan Software ERP';

        $priceFormatted = number_format($price, 2, ',', '.');

        $body = "
            <html>
            <body>
                    <h2>Serviço Finalizado</h2>

                    <p>Olá, $toName!</p>
                    <p>O serviço <strong>$description</strong> foi finalizado com sucesso.</p>
                    <p>Valor do serviço: R$$priceFormatted</p>
                    <p>Agradecemos por utilizar o Titan Software ERP!</p>
                </body>
        ";

        $socket = null;

        try {
            $socket = stream_socket_client('tcp://' . self::SMTP_HOST . ':' . self::SMTP_PORT, $errno, $errstr, 30);

            if (!$socket) {
                throw new Exception("Erro ao conectar ao servidor SMTP: $errstr ($errno)");
            }

            self::expectResponse($socket, 220);
            self::command($socket, "EHLO localhost", 250);
            self::command($socket, 'STARTTLS', 220);

            $crypto = stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);

            if (!$crypto) {
                throw new Exception("Erro ao iniciar criptografia TLS.");
            }

            self::command($socket, "EHLO localhost", 250);
            self::command($socket, "AUTH LOGIN", 334);
            self::command($socket, base64_encode(self::SMTP_USERNAME), 334);
            self::command($socket, base64_encode(self::SMTP_PASSWORD), 235);
            self::command($socket, "MAIL FROM:<" . self::SMTP_USERNAME . ">", 250);
            self::command($socket, "RCPT TO:<$toEmail>", 250);
            self::command($socket, "DATA", 354);

            $headers = [];

            $headers[] = "From: Titan Software ERP <" . self::SMTP_USERNAME . ">";
            $headers[] = "To: " . self::encodeHeader($toName) . " <" . $toEmail . ">";
            $headers[] = "Subject: " . self::encodeHeader($subject);
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=UTF-8";
            $headers[] = "Content-Transfer-Encoding: 8bit";

            $email = implode("\r\n", $headers) . "\r\n\r\n" . $body . "\r\n.";

            self::command($socket, $email, 250);
            self::command($socket, "QUIT");

            fwrite($socket, "QUIT\r\n");

            fclose($socket);

            return true;
        } catch (Exception $e) {
            error_log('Erro ao enviar e-mail: ' . $e->getMessage());
            return false;
        }
    }

    private static function command($socket, $command, $expectedCode = null)
    {
        fwrite($socket, $command . "\r\n");
        self::expectResponse($socket, $expectedCode);
    }

    private static function expectResponse($socket, $expectedCode)
    {
        $response = '';
        while (($line = fgets($socket, 515)) !== false) {
            $response .= $line;
            if (strlen($line) >= 4 && $line[3] === ' ') {
                break;
            }
        }

        if ($response === '') {
            throw new Exception("Erro ao ler a resposta do servidor SMTP.");
        }

        $code = (int) substr($response, 0, 3);

        if ($code !== $expectedCode) {
            throw new Exception("Resposta inesperada do servidor SMTP: $response");
        }
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private static function encodeHeader(string $value): string
    {
        return '=?UTF-8?B?' . base64_encode($value) . '?=';
    }
}