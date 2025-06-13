<?php

namespace App\SendMail\Builder;

class MailContentBuilder
{
    private array $subjectTemplates;
    private array $bodyTemplates;

    public function __construct(array $subjectTemplates)
    {
        $this->subjectTemplates = $subjectTemplates;
        $this->bodyTemplates = [
            'reservation' => [
                'user' => $this->loadTemplate('reservation_user_body.php'),
                'admin' => $this->loadTemplate('reservation_admin_body.php'),
            ],
            'consultation' => [
                'user' => $this->loadTemplate('consultation_user_body.php'),
                'admin' => $this->loadTemplate('consultation_admin_body.php'),
            ],
        ];
    }

    public function buildSubject(string $formType, string $recipientType, array $data): string
    {
        $template = $this->subjectTemplates[$formType][$recipientType] ?? '';

        return $this->replacePlaceholders($template, $data);
    }

    public function buildBody(string $formType, string $recipientType, array $data): string
    {
        $template = $this->bodyTemplates[$formType][$recipientType] ?? '';

        return $this->replacePlaceholders($template, $data);
    }

    private function replacePlaceholders(string $template, array $data): string
    {
        $replacements = [];
        foreach ($data as $key => $value) {
            if (in_array($key, ['desiredTime', 'contactTime'])) {
                $replacements['{{'.$key.'}}'] = str_replace('～', '~', htmlspecialchars($value));
            } elseif ('desiredDate' === $key) {
                $dateTime = \DateTime::createFromFormat('Y-m-d', $value, new \DateTimeZone('Asia/Tokyo'));
                $replacements['{{'.$key.'}}'] = $dateTime ? $dateTime->format('Y年m月d日') : htmlspecialchars($value);
            } elseif ('clinicTel' === $key) {
                $replacements['{{'.$key.'}}'] = htmlspecialchars($value ?? $_ENV['OFFICIAL_TEL_NUMBER']);
            } elseif ('message' === $key) {
                $replacements['{{'.$key.'}}'] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            } elseif (is_array($value)) {
                $replacements['{{'.$key.'}}'] = implode(', ', array_map('htmlspecialchars', $value));
            } else {
                $replacements['{{'.$key.'}}'] = htmlspecialchars($value ?? '');
            }
        }

        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    private function loadTemplate(string $filename): string
    {
        $templatePath = __DIR__.'/templates/'.$filename;
        if (file_exists($templatePath)) {
            ob_start();
            include $templatePath;

            return ob_get_clean();
        }

        return '該当するテンプレートがありません';
    }

}
