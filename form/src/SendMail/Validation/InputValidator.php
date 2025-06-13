<?php

namespace App\SendMail\Validation;

class InputValidator
{
    private array $filterArgs;
    private string $recaptchaSecretKey;

    public function __construct(array $filterArgs, string $recaptchaSecretKey)
    {
        $this->filterArgs = $filterArgs;
        $this->recaptchaSecretKey = $recaptchaSecretKey;
    }

    public function validate(array $postData): array
    {
        $filteringResult = filter_var_array($postData, $this->filterArgs);

        if (false === $filteringResult || null === $filteringResult) {
            throw new \InvalidArgumentException('入力データのフィルタリングに失敗しました。');
        }

        if (isset($filteringResult['recaptchaToken'])) {
            $recaptchaResponse = $this->verifyRecaptcha($filteringResult['recaptchaToken']);
            if ( ! $recaptchaResponse['success'] || ($recaptchaResponse['score'] ?? 0) < 0.3) {
                throw new \InvalidArgumentException('reCAPTCHA の検証に失敗しました。');
            }
        }

        if (isset($filteringResult['formType']) && 'reservation' === $filteringResult['formType'] && isset($filteringResult['desiredDate'])) {
            $desiredDate = $filteringResult['desiredDate'];
            $parsed = \DateTime::createFromFormat('Y-m-d', $desiredDate, new \DateTimeZone('Asia/Tokyo'));
            $today = new \DateTime('today', new \DateTimeZone('Asia/Tokyo'));
            $twoMonthsLater = (new \DateTime('now', new \DateTimeZone('Asia/Tokyo')))->modify('+2 months');
            if ( ! $parsed || $parsed->format('Y-m-d') !== $desiredDate || $parsed < $today || $parsed > $twoMonthsLater) {
                throw new \InvalidArgumentException('無効な日付形式です。');
            }
        }

        return $filteringResult;
    }

    private function verifyRecaptcha(string $token): array
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $this->recaptchaSecretKey,
            'response' => $token,
        ];
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        return json_decode($response, true) ?? ['success' => false];
    }
}
