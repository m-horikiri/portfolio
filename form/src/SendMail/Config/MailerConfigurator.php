<?php

namespace App\SendMail\Config;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailerConfigurator
{
    private array $smtpConfigs;

    public function __construct(array $smtpConfigs)
    {
        $this->smtpConfigs = $smtpConfigs;
    }

    public function configure(PHPMailer $mailer, string $formType): void
    {
        $mailer->isSMTP();
        $mailer->SMTPDebug = SMTP::DEBUG_OFF;
        $mailer->Host = $this->smtpConfigs['host'] ?? '';
        $mailer->Port = $this->smtpConfigs['port'] ?? 465;
        $mailer->SMTPSecure = $this->smtpConfigs['secure'] ?? PHPMailer::ENCRYPTION_SMTPS;
        $mailer->SMTPAuth = true;
        $mailer->Username = $this->smtpConfigs[$formType]['username'] ?? '';
        $mailer->Password = $this->smtpConfigs[$formType]['password'] ?? '';
        $mailer->CharSet = 'UTF-8';
        $mailer->Encoding = 'base64';
    }
}
