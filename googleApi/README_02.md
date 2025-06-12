# Google Ads Api コンバージョン調整

[公式リファレンス](https://developers.google.com/google-ads/api/docs/start)

[公式リファレンス「コンバージョンの調整をアップロード」](https://developers.google.com/google-ads/api/docs/conversions/upload-adjustments?hl=ja)

インストールやOAuth2の認証はオフラインコンバージョンのアップロードと同一となります為割愛いたします。

オフラインコンバージョンのアップロード処理に追加する形を想定して記述しております。

なお、今回の検証はオフラインコンバージョンのアップロード時よりバージョンを変更しております。

[下記](#環境)をご参考いただけますと幸いです。

## 追加使用する名前空間

```php
use Google\Ads\GoogleAds\V19\Enums\ConversionAdjustmentTypeEnum\ConversionAdjustmentType;
use Google\Ads\GoogleAds\V19\Services\ClickConversionResult;
use Google\Ads\GoogleAds\V19\Services\ConversionAdjustment;
use Google\Ads\GoogleAds\V19\Services\ConversionAdjustmentResult;
use Google\Ads\GoogleAds\V19\Services\RestatementValue;
use Google\Ads\GoogleAds\V19\Services\UploadConversionAdjustmentsRequest;
```

## 広告ID・コンバージョンアクションIDの振り分け

[送付済のスプレッドシート](https://docs.google.com/spreadsheets/)を参考に、広告IDとコンバージョンアクションIDが設定される用にご変更いただくとスムーズかと存じます。

```php
    // 広告ID
    $customer_id = '';
    // コンバージョンアクションID（テスト用）
    $conversion_action_id = '';

    // $media = 取り込み時の媒体名
    if(str_contains($media, '比較')) {
        // 比較サイト
        $customer_id = '*****';
        $conversion_action_id = '*****';
    }else if(str_contains($media, 'MS')){
        // 清佑会
        $customer_id = '*****';
        $conversion_action_id = '*****';
    }else{
        // PIA
        $customer_id = '*****';
        $conversion_action_id = '*****';
    }
```

## オフラインコンバージョンアップロード時の追加設定

調整のアップロード時に必要な`$order_id`を追加する必要がございます。

オフラインコンバージョンアップロード処理の際に一意のIDをデータに含めるように変更いただけますと幸いです。

```php
    // コンバージョンのデータを作成
    $conversion = new ClickConversion([
        'gclid' => $gclid,
        'conversion_action' => ResourceNames::forConversionAction($customer_id, $conversion_action_id),
        'conversion_date_time' => $conversion_time,
        'conversion_value' => $conversion_value,
        'currency_code' => 'JPY',
        // 下記を追加
        'order_id' => $order_id,
    ]);
```

`$order_id`の生成タイミングはお任せいたしますが、コンバージョンの調整でのみ使用される場合はオフラインコンバージョンアップロード時に生成しても問題ないかと存じます。

システム仕様や運用方法をご確認いただき、適宜ご設定いただけますと幸いです。

なお、`$order_id`は重複しない一意のIDであれば何をご設定いただいても問題ございませんが、UUIDを生成することを推奨いたします。

### UUID生成におすすめのライブラリ

PHPには`uniqid`という関数があり、これを使用すると簡単にユニークなIDを生成することができますが、より堅牢なUUIDを生成するには、`ramsey/uuid`というライブラリを使用することを推奨いたします。

このライブラリはComposerを通じて簡単にインストールが可能です。

```bash
$ composer require ramsey/uuid
```

使用例

```php
<?php
    require_once 'vendor/autoload.php';
    use Ramsey\Uuid\Uuid;
    $order_id = Uuid::uuid4();
```

[様々なバージョンのUUIDが生成可能](https://uuid.ramsey.dev/en/stable/quickstart.html#using-ramsey-uuid)な為、適宜ご使用いただけますと幸いです。

## コンバージョン調整のアップロード

```php
    /**
     * オフラインコンバージョンの調整
     *
     * @param string $customer_id 広告アカウントID
     * @param int $conversion_action_id コンバージョンアクションID
     * @param string $order_id アップロード時に生成した一意のID
     * @param string $adjustment_type 調整タイプ（"RESTATEMENT"または"RETRACTION"）
     * @param int $restatement_value 修正後のコンバージョン値
     * @param string $adjustment_date_time 修正日時（'YYYY-MM-DD HH:MM:SS+HH:MM' 形式）
     * @return array アップロード結果（検証結果、広告アカウントID、コンバージョンアクションID、注文ID、コンバージョン日時、コンバージョン値、エラーメッセージ）
     */
    public function adjustmentUploadConversion($customer_id, $conversion_action_id, $order_id, $adjustment_type, $restatement_value, $adjustment_date_time){

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
        ];

        // 部分的なエラー情報があるかチェック
        $partialFailureErrors = $response->getPartialFailureError();
        if ($partialFailureErrors) {
            array_merge($result, [
                'status' => 'error',
                'errors' => $partialFailureErrors->getMessage(),
            ]);
        } else {
            // レスポンスの詳細を取得
            /** @var ConversionAdjustmentResult $uploadedConversionAdjustment */
            $uploadedConversionAdjustment = $response->getResults()[0];
            array_merge($result, [
                'status' => 'success',
                'order_id' => $uploadedConversionAdjustment->getOrderId(),
                'adjustment_type' => ConversionAdjustmentType::name($uploadedConversionAdjustment->getAdjustmentType()),
                'adjustment_date_time' => $uploadedConversionAdjustment->getAdjustmentDateTime()
            ]);
        }
        return $result;
    }
```

### コンバージョン調整データの入力規則

```php
    $conversionAdjustment = new ConversionAdjustment([
        'conversion_action' => ResourceNames::forConversionAction($customer_id, $conversion_action_id),
        'adjustment_type' => $adjustmentType,
        'restatement_value' => new RestatementValue(['adjusted_value' => $restatement_value]),
        'order_id' => $order_id,
        'adjustment_date_time' => $adjustment_date_time
    ]);
```

- `conversion_action`：string型。このコンバージョンに関連付けられたコンバージョンアクションのリソース名。

- `adjustment_type`：[ConversionAdjustmentType](https://developers.google.com/google-ads/api/reference/rpc/v19/ConversionAdjustmentTypeEnum.ConversionAdjustmentType)型。調整タイプ。

- `restatement_value`：[RestatementValue](https://developers.google.com/google-ads/api/reference/rpc/v19/RestatementValue)型。コンバージョン値の変更時に必要な情報で、**__`adjustment_type`が`RESTATEMENT`の時は必須__**ですが**__`adjustment_type`が`RETRACTION`の時は指定不可__**です。

- `order_id`：string型。調整するコンバージョンの一意のID。コンバージョンが`order_id`を指定して報告された場合、それを識別子として使用する必要があります。

- `adjustment_date_time`：string型。調整が行われた日時。オフラインコンバージョンのアップロード時刻より後の日時である必要があり、**__タイムゾーンを指定する必要があります__**。

**`adjustment_type`の構成**

- `RESTATEMENT`：アップロードしたコンバージョン値を変換する指定。**`restatement_value`が必須**。

- `RETRACTION`：アップロードしたコンバージョンを削除する指定。**`restatement_value`を送るとエラー**が発生する。

記載しているデモコードでは`adjustment_type`が`RESTATEMENT`かつ、調整後のコンバージョン値が空でない場合のみ`restatement_value`を生成しております。

同一のコンバージョンにおいて、複数回コンバージョン値の修正を送信する場合は、調整日時（`adjustment_date_time`）をより新しい時刻に変更する必要があります。

調整日時が新しい日付でない場合は重複と扱われ、エラーが返ります。

**`adjustment_date_time`の形式**

```
yyyy-mm-dd hh:mm:ss+|-hh:mm // 例：2025-02-26 15:00:00+09:00
```

GMTを入れた指定の形式にフォーマットする必要があります。

### validateOnlyフラグ

uploadClickConversionsメソッドのリクエストパラメータの中に、validateOnlyというフラグが存在します。

```php
    $request = new UploadConversionAdjustmentsRequest([
        // 必須：広告アカウントのID
        'customer_id' => $customer_id,
        
        // 必須：コンバージョン調整データ
        'conversion_adjustments' => [$conversionAdjustment],
        
		// 必須：同一リクエスト内の他のオペレーションが
		// 　　　失敗しても処理を続行し、有効なオペレーションは実行
		// 　　　無効なオペレーションはエラーを返す
        'partial_failure' => true,
		
        // 任意：リクエストの検証のみを行うかの指定
		'validate_only' => true
    ]);
```

`validateOnly`を`true`に指定すると実際にアップロードはされずエラーのみ返却されます。

なお、`validateOnly`を`true`に指定した場合は成功データ（[ConversionAdjustmentResult](https://developers.google.com/google-ads/api/reference/rpc/v19/ConversionAdjustmentResult)）が返却されない為、送信内容の検証結果を得ることはできません。

## 未実装の機能

コンバージョン調整は、オフラインコンバージョンのアップロードから24時間以上経過していないデータを調整することはできません。

また、54日以上前に発生したコンバージョンを調整することができません。

そして同一のコンバージョンの調整を複数回行う場合は、`adjustment_date_time`がより新しい日付である必要があります。


- オフラインコンバージョンアップロードからの経過時間（**__24時間以上54日以内__**）検証 

- 同一コンバージョン調整時の`adjustment_date_time`検証

誠に申し訳ございませんが、こちらのバリデーションを実装できておりません。

## 環境

| 言語・フレームワーク | バージョン |
| ------------------ | --------- |
| Composer           | 2.8.2     |
| php                | 8.3.19    |
| Laravel            | 12.1.1    |
| google-ads-php     | 26.1.0    |
| Google Ads API     | v19       |
