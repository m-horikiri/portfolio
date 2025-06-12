<?php

namespace App\Services;

use Google\Ads\GoogleAds\V19\Enums\ConversionActionCategoryEnum\ConversionActionCategory;
use Google\Ads\GoogleAds\V19\Enums\ConversionActionStatusEnum\ConversionActionStatus;
use Google\Ads\GoogleAds\V19\Enums\ConversionActionTypeEnum\ConversionActionType;
use Google\Ads\GoogleAds\V19\Enums\ConversionAdjustmentTypeEnum\ConversionAdjustmentType;
use Google\Ads\GoogleAds\V19\Resources\ConversionAction;
use Google\Ads\GoogleAds\V19\Resources\ConversionAction\ValueSettings;
use Google\Ads\GoogleAds\V19\Services\ClickConversion;
use Google\Ads\GoogleAds\V19\Services\ClickConversionResult;
use Google\Ads\GoogleAds\V19\Services\ConversionActionOperation;
use Google\Ads\GoogleAds\V19\Services\ConversionAdjustment;
use Google\Ads\GoogleAds\V19\Services\ConversionAdjustmentResult;
use Google\Ads\GoogleAds\V19\Services\GoogleAdsRow;
use Google\Ads\GoogleAds\V19\Services\MutateConversionActionsRequest;
use Google\Ads\GoogleAds\V19\Services\RestatementValue;
use Google\Ads\GoogleAds\V19\Services\SearchGoogleAdsRequest;
use Google\Ads\GoogleAds\V19\Services\UploadClickConversionsRequest;
use Google\Ads\GoogleAds\V19\Services\UploadConversionAdjustmentsRequest;
use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use Google\Ads\GoogleAds\Lib\V19\GoogleAdsClientBuilder;
use Google\Ads\GoogleAds\Util\V19\ResourceNames;

class GoogleAdsService
{
    protected $googleAdsClient;
    protected $customerId = '*****';

    public function __construct()
    {
        $this->googleAdsClient = (new GoogleAdsClientBuilder())
            // storage_path('app/private/google_ads_php.ini') =
            // storage/app/private/google_ads_php.ini
            ->fromFile(storage_path('app/private/google_ads_php.ini'))
            ->withOAuth2Credential((new OAuth2TokenBuilder())
                    ->fromFile(storage_path('app/private/google_ads_php.ini'))
                    ->build())
            ->build();
    }


    // コンバージョンアクションを取得
    public function getConversionActions($customer_id)
    {
        // クエリを作成
        $query = "SELECT conversion_action.id, conversion_action.name, conversion_action.type, conversion_action.status, conversion_action.resource_name FROM conversion_action";

        // SearchGoogleAdsRequest のリクエストオブジェクトを作成
        $request = new SearchGoogleAdsRequest([
            'customer_id' => $customer_id,
            'query' => $query
        ]);

        // クエリを実行
        $response = $this->googleAdsClient->getGoogleAdsServiceClient()->search($request);

        // 結果をパース
        $conversionActions = [];
        foreach ($response->iterateAllElements() as $googleAdsRow) {
            /** @var GoogleAdsRow $googleAdsRow */
            $conversionAction = $googleAdsRow->getConversionAction();
            $conversionActions[] = [
                'resource_name' => $conversionAction->getResourceName(),
                'id' => $conversionAction->getId(),
                'name' => $conversionAction->getName(),
                'category' => ConversionActionCategory::name($conversionAction->getCategory()),
                'type' => ConversionActionType::name($conversionAction->getType()),
                'status' => ConversionActionStatus::name($conversionAction->getStatus()),
            ];
        }

        return $conversionActions;
    }


    // uploaded
    public function getUploaded($customer_id)
    {
        // クエリを作成
        $query = <<<GAQL
        SELECT
            offline_conversion_upload_conversion_action_summary.resource_name,
            offline_conversion_upload_conversion_action_summary.client,
            offline_conversion_upload_conversion_action_summary.conversion_action_id,
            offline_conversion_upload_conversion_action_summary.conversion_action_name,
            offline_conversion_upload_conversion_action_summary.total_event_count,
            offline_conversion_upload_conversion_action_summary.successful_event_count,
            offline_conversion_upload_conversion_action_summary.pending_event_count,
            offline_conversion_upload_conversion_action_summary.last_upload_date_time,
            offline_conversion_upload_conversion_action_summary.alerts
        FROM
            offline_conversion_upload_conversion_action_summary
GAQL;

        // SearchGoogleAdsRequest のリクエストオブジェクトを作成
        $request = new SearchGoogleAdsRequest([
            'customer_id' => $customer_id,
            'query' => $query
        ]);

        // クエリを実行
        $response = $this->googleAdsClient->getGoogleAdsServiceClient()->search($request);
        $datas = [];
        foreach ($response->getIterator() as $row) {
            $summary = $row->getOfflineConversionUploadConversionActionSummary();

            $data = [];
            $data['actionId'] = $summary->getConversionActionId();
            $data['actionName'] = $summary->getConversionActionName();
            $data['totalEvent'] = $summary->getTotalEventCount();
            $data['successEvent'] = $summary->getSuccessfulEventCount();
            $data['holdEvent'] = $summary->getPendingEventCount();
            $data['lastUploadDate'] = $summary->getLastUploadDateTime();

            $datas[] = $data;
        }
        return $datas;
    }

    /**
     * オフラインコンバージョンアップロード
     *
     * @param string $media メディア名（'比較', 'MS' を含む場合、それぞれ特定の顧客IDを使用）
     * @param string $gclid Google Click Identifier
     * @param string $conversion_time コンバージョン日時（'YYYY-MM-DD HH:MM:SS+HH:MM' 形式）
     * @param float $conversion_value コンバージョン値
     * @param int $conversion_action_id コンバージョンアクションID
     * @param string $order_id 注文ID
     * @param bool $validate_only 検証のみ実行するか
     * @return array アップロード結果（検証結果、顧客ID、GCLID、コンバージョンアクションID、コンバージョン日時、コンバージョン値、注文ID、ステータス、エラーメッセージ）
     */
    public function uploadOfflineConversion($media, $gclid, $conversion_time, $conversion_value, $conversion_action_id, $order_id, $validate_only = 1)
    {
        $validate_only = (bool) $validate_only;

        // 広告IDの特定
        if(str_contains($media, '比較')) {
            $customer_id = '*****';
        }else if(str_contains($media, 'MS')){
            $customer_id = '*****';
        }else{
            $customer_id = '*****';
        }

        // コンバージョンのデータを作成
        $conversion = new ClickConversion([
            'gclid' => $gclid,
            'conversion_action' => ResourceNames::forConversionAction($customer_id, $conversion_action_id),
            'conversion_date_time' => $conversion_time,
            'conversion_value' => $conversion_value,
            'currency_code' => 'JPY',
            'order_id' => $order_id,
        ]);

        // リクエストの作成
        $request = new UploadClickConversionsRequest([
            'customer_id' => $customer_id,
            'conversions' => [$conversion],
            'partial_failure' => true,
            'validate_only' => $validate_only,
        ]);

        // APIリクエストを送信
        $response = $this->googleAdsClient->getConversionUploadServiceClient()
            ->uploadClickConversions($request);

        $result = [
            'validate_only' => $validate_only,
            'customer_id' => $customer_id,
            'gclid' => $gclid,
            'conversion_action_id' => $conversion_action_id,
            'conversion_date_time' => $conversion_time,
            'conversion_value' => $conversion_value,
            'order_id' => $order_id
        ];

        // 部分的なエラー情報があるかチェック
        $partialFailureErrors = $response->getPartialFailureError();
        if ($partialFailureErrors) {
            $result['status'] = 'error';
            $result['errors'] = $partialFailureErrors->getMessage();
            var_dump( $partialFailureErrors);
            die;
        } else {
            $result['status'] = 'success';
            // validate_only=false の場合のみ、アップロード結果を取得
            if($validate_only === false){
                // レスポンスの詳細を取得
                /** @var ClickConversionResult $uploadedClickConversion */
                $uploadedConversion = $response->getResults()[0];
                $result['gclid'] = $uploadedConversion->getGclid();
                $result['conversion_date_time'] = $uploadedConversion->getConversionDateTime();
                $result['conversion_action'] = $uploadedConversion->getConversionAction();
            }
        }
        return $result;
    }

    /**
     * オフラインコンバージョンの調整
     *
     * @param string $customer_id 広告アカウントID
     * @param int $conversion_action_id コンバージョンアクションID
     * @param string $order_id アップロード時に生成した一意のID
     * @param string $adjustment_type 調整タイプ（"RESTATEMENT"または"RETRACTION"）
     * @param int $restatement_value 修正後のコンバージョン値
     * @param string $adjustment_date_time 修正日時（'YYYY-MM-DD HH:MM:SS+HH:MM' 形式）
     * @param bool $validate_only 検証のみ実行するか
     * @return array アップロード結果（検証結果、顧客ID、GCLID、コンバージョンアクションID、コンバージョン日時、コンバージョン値、注文ID、ステータス、エラーメッセージ）
     */
    public function adjustmentUploadConversion($customer_id, $conversion_action_id, $order_id, $adjustment_type, $restatement_value, $adjustment_date_time, $validate_only = 1){
        $validate_only = (bool) $validate_only;

        // 調整タイプを設定
        $adjustmentType = ConversionAdjustmentType::value($adjustment_type);

        // 調整データ作成
        $conversionAdjustment = new ConversionAdjustment([
            'conversion_action' => ResourceNames::forConversionAction($customer_id, $conversion_action_id),
            'adjustment_type' => $adjustmentType,
            'order_id' => $order_id,
            'adjustment_date_time' => $adjustment_date_time
        ]);

        // コンバージョン値の修正の場合
        if($adjustmentType === ConversionAdjustmentType::RESTATEMENT
         && !empty($restatement_value)){
            $conversionAdjustment->setRestatementValue(new RestatementValue([
                'adjusted_value' => $restatement_value
            ]));
        }

        // リクエストの作成
        $request = new UploadConversionAdjustmentsRequest([
            'customer_id' => $customer_id,
            'conversion_adjustments' => [$conversionAdjustment],
            'partial_failure' => true,
            'validate_only' => $validate_only,
        ]);

        // APIリクエストを送信
        $response = $this->googleAdsClient->getConversionAdjustmentUploadServiceClient()->uploadConversionAdjustments($request);

        $result = [
            'customer_id' => $customer_id,
            'conversion_action_id' => $conversion_action_id,
            'order_id' => $order_id,
            'adjustment_type' => $adjustmentType,
            'adjusted_value' => $restatement_value ? $restatement_value : '',
            'adjustment_date_time' => $adjustment_date_time,
            'validate_only' => $validate_only,
        ];

        // 部分的なエラー情報があるかチェック
        $partialFailureErrors = $response->getPartialFailureError();
        if ($partialFailureErrors) {
            $result['status'] = 'error';
            $result['errors'] = $partialFailureErrors->getMessage();
        } else {
            $result['status'] = 'success';
            // validate_only=false の場合のみ、アップロード結果を取得
            if($validate_only === false){
                // レスポンスの詳細を取得
                /** @var ClickConversionResult $uploadedClickConversion */
                $uploadedConversionAdjustment = $response->getResults()[0];
                $result['order_id'] = $uploadedConversionAdjustment->getOrderId();
                $result['adjustment_type'] = $uploadedConversionAdjustment->getAdjustmentType();
                $result['adjustment_date_time'] = $uploadedConversionAdjustment->getAdjustmentDateTime();
            }
        }

        return $result;
    }
}
