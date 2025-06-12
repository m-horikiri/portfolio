<?php

namespace App\SendMail\Processor;

use App\SendMail\Builder\MailContentBuilder;
use App\SendMail\Config\MailerConfigurator;
use App\SendMail\Sender\EmailSender;
use App\SendMail\Validation\InputValidator;
use PHPMailer\PHPMailer\PHPMailer;

class FormProcessor
{
    private MailerConfigurator $configurator;
    private InputValidator $validator;
    private MailContentBuilder $contentBuilder;
    private EmailSender $sender;
    private PHPMailer $phpMailer;

    public function __construct(
        MailerConfigurator $configurator,
        InputValidator $validator,
        MailContentBuilder $contentBuilder,
        EmailSender $sender,
        PHPMailer $phpMailer
    ) {
        $this->configurator = $configurator;
        $this->validator = $validator;
        $this->contentBuilder = $contentBuilder;
        $this->sender = $sender;
        $this->phpMailer = $phpMailer;
    }

    public function process(string $formType, array $postData): bool
    {
        if ('reservation' === $formType) {
            $senderName = trim($_ENV['SENDER_NAME_RESERVE'] ?? 'MSクリニック来院予約受付');
            $adminEmail = $_ENV['USER_NAME_RESERVE'] ?? 'reserve@mens-spclinic.jp';
        } elseif ('consultation' === $formType) {
            $senderName = trim($_ENV['SENDER_NAME_CONSULTATION'] ?? 'MSクリニック無料相談受付');
            $adminEmail = $_ENV['USER_NAME_CONSULTATION'] ?? 'soudan@mens-spclinic.jp';
        }

        try {
            $validatedData = $this->validator->validate($postData);
            $this->configurator->configure($this->phpMailer, $formType);

            // ユーザー宛メール
            $userSubject = $this->contentBuilder->buildSubject($formType, 'user', $validatedData);
            $userBody = $this->contentBuilder->buildBody($formType, 'user', $validatedData);
            $userEmail = $validatedData['email'] ?? '';

            $userSent = true;
            if ($userEmail) {
                $userSent = $this->sender->send($this->phpMailer, $userEmail, $userSubject, $userBody, '', [], $senderName);
            }

            // 管理者宛メール
            $adminSubject = $this->contentBuilder->buildSubject($formType, 'admin', $validatedData);
            $adminBody = $this->contentBuilder->buildBody($formType, 'admin', $validatedData);
            $adminBccString = $_ENV['BCC_ADDRESSES'] ?? '';
            $adminBcc = array_map('trim', explode(',', $adminBccString));
            $adminBcc = array_filter($adminBcc);

            $adminSent = true;
            if ($adminEmail) {
                $adminSent = $this->sender->send($this->phpMailer, $adminEmail, $adminSubject, $adminBody, $userEmail, $adminBcc, 'MSクリニック');
            }

            return $userSent && $adminSent;

        } catch (\InvalidArgumentException $e) {
            error_log("検証エラー: {$e->getMessage()}");

            return false;
        } catch (\Exception $e) {
            error_log("処理エラー: {$e->getMessage()}");

            return false;
        }
    }
}
