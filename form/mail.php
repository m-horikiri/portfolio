<?php

header('Content-Type: application/json; charset=UTF-8');

$allowedOrigins = [
    'https://example.com',
];

$requestOrigin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($requestOrigin, $allowedOrigins)) {
    header('Access-Control-Allow-Origin: '.$requestOrigin);
} else {
    http_response_code(400);
    echo json_encode(['status' => false, 'message' => "{$requestOrigin}は許可されていないオリジンです。"]);
    exit;
}

header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Max-Age: 600');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => false, 'message' => 'POSTメソッドのみ許可されています。']);
    exit;
}

require_once __DIR__.'/vendor/autoload.php';

use App\SendMail\Builder\MailContentBuilder;
use App\SendMail\Config\MailerConfigurator;
use App\SendMail\Processor\FormProcessor;
use App\SendMail\Sender\EmailSender;
use App\SendMail\Validation\InputValidator;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// リクエストデータの取得
$requestData = json_decode(file_get_contents('php://input'), true);

if ($requestData === null && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => '無効なJSONデータです。']);
    exit;
}

$requestDataFilter = [
    'formType' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'data' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_REQUIRE_ARRAY,
    ],
];

$requestDataFiltering = filter_var_array($requestData, $requestDataFilter);

if ( ! isset($requestDataFiltering['formType']) || ! is_array($requestDataFiltering['data'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => '送信データに誤りがあります。']);
    exit;
}

$formType = $requestDataFiltering['formType'];
$postData = $requestDataFiltering['data'];

$smtpConfigs = [
    'host' => $_ENV['SMTP_HOST'],
    'port' => $_ENV['SMTP_PORT'],
    'secure' => 'ssl',
    'reservation' => [
        'username' => $_ENV['USER_NAME_RESERVE'],
        'password' => $_ENV['PASSWORD_RESERVE'],
    ],
    'consultation' => [
        'username' => $_ENV['USER_NAME_CONSULTATION'],
        'password' => $_ENV['PASSWORD_CONSULTATION'],
    ],
];

$subjectTemplates = [
    'reservation' => [
        'user' => $_ENV['SUBJECT_RESERVE'],
        'admin' => '{{media}}からの予約について',
    ],
    'consultation' => [
        'user' => $_ENV['SUBJECT_CONSULTATION'],
        'admin' => '{{media}}からの相談について',
    ],
];

$filterArgsReservation = [
    'treatment' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_REQUIRE_ARRAY,
    ],
    'clinic' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'email' => FILTER_VALIDATE_EMAIL,
    'telNumver' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => [
            'regexp' => '/^(0\d{9,10}|0\d{1,3}[-\s]\d{2,4}[-\s]\d{2,4})$/',
        ],
    ],
    'desiredDate' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => [
            'regexp' => '/^20\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/',
        ],
    ],
    'desiredTime' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => [
            'regexp' => '/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]～(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',
        ],
    ],
    'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'age' => [
        'filter' => FILTER_VALIDATE_INT,
        'options' => [
            'min_range' => 10,
            'max_range' => 100,
        ],
    ],
    'contactTime' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => [
            'regexp' => '/^((0[0-9]|1[0-9]|2[0-3])時～(0[0-9]|1[0-9]|2[0-3])時|いつでも)$/',
        ],
    ],
    'message' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'media' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'gclid' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'clinicTel' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => [
            'regexp' => '/^0\d{1,3}-\d{2,4}-\d{2,4}$/',
        ],
    ],
    'recaptchaToken' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
];
$filterArgsConsultation = [
    'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'email' => FILTER_VALIDATE_EMAIL,
    'diagnosticItems' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_REQUIRE_ARRAY,
    ],
    'consultationDetails' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_REQUIRE_ARRAY,
    ],
    'message' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'media' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'gclid' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'clinicTel' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => [
            'regexp' => '/^0\d{1,3}-\d{2,4}-\d{2,4}$/',
        ],
    ],
    'recaptchaToken' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
];

$filterArgsByType = [
    'reservation' => $filterArgsReservation,
    'consultation' => $filterArgsConsultation,
];

$recaptchaSecretKey = $_ENV['RECAPTCHA_SECRET_KEY'] ?? '';

$mailerConfigurator = new MailerConfigurator($smtpConfigs);
$inputValidator = new InputValidator($filterArgsByType[$requestData['formType'] ?? 'reservation'], $recaptchaSecretKey);
$mailContentBuilder = new MailContentBuilder($subjectTemplates);
$emailSender = new EmailSender();
$phpMailer = new PHPMailer(true);

$formProcessor = new FormProcessor(
    $mailerConfigurator,
    $inputValidator,
    $mailContentBuilder,
    $emailSender,
    $phpMailer
);

$result = $formProcessor->process($formType, $postData);

if (true === $result) {
    if($formType === 'reservation'){
        // 確認用にデータログで記録
        $data = [
            'date' => date('Y-m-d H:i'),
            'media' => $postData['media'] ?? '',
            'gclid' => $postData['gclid'] ?? '',
            'cookie_gclid' => $postData['cookie_gclid'] ?? '',
            'cookie_gclid_browser' => $postData['cookie_gclid_browser'] ?? '',
            'name' => $postData['name'] ?? '',
            'mail' => $postData['email'] ?? '',
            'tel' => $postData['telNumver'] ?? ''
        ];
        $logLine = json_encode($data) . PHP_EOL;
        file_put_contents(__DIR__.'/../../../log/form_reservation_submissions.log', $logLine, FILE_APPEND | LOCK_EX);
    }
    http_response_code(200);
    echo json_encode(['status' => true, 'message' => '送信成功']);
} else {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => '送信失敗', 'details' => $result]);
}
