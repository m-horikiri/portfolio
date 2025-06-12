<?php

namespace App\SendMail\Sender;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailSender
{
    public function send(PHPMailer $mailer, string $to, string $subject, string $body, string $from = '', array $bcc = [], string $senderName = ''): bool
    {
        $from = ! empty($from) ? $from : $mailer->Username;
        $senderName = ! empty($senderName) ? $senderName : 'MSクリニック';

        $mailer->setFrom($from, $senderName);
        $mailer->clearAllRecipients();
        $mailer->addAddress($to);
        $mailer->Subject = $subject;
        $mailer->Body = $body;

        if ( ! empty($bcc)) {
            foreach ($bcc as $val) {
                $mailer->addBCC($val);
            }
        }

        try {
            return $mailer->send();
        } catch (\Exception $e) {
            print_r("メール送信エラー: {$mailer->ErrorInfo}");

            return false;
        }
    }
}
