<?php

namespace App\Lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
    public static function send(string $toEmail, string $toName, string $subject, string $body): bool
    {
        $config = Db::loadConfig();
        $mailConfig = $config['mail'] ?? [];

        $mailer = new PHPMailer(true);
        $mailer->isSMTP();
        $mailer->Host = $mailConfig['host'] ?? '';
        $mailer->SMTPAuth = true;
        $mailer->Username = $mailConfig['username'] ?? '';
        $mailer->Password = $mailConfig['password'] ?? '';
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailer->Port = $mailConfig['port'] ?? 587;
        $mailer->CharSet = 'UTF-8';

        $mailer->setFrom($mailConfig['from_email'] ?? 'no-reply@example.com', $mailConfig['from_name'] ?? 'Paróquia');
        $mailer->addAddress($toEmail, $toName);
        $mailer->Subject = $subject;
        $mailer->isHTML(true);
        $mailer->Body = $body;

        return $mailer->send();
    }
}
