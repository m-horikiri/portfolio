# Google Ads Apiでオフラインコンバージョンのアップロード

[公式リファレンス](https://developers.google.com/google-ads/api/docs/start)

[公式リファレンス「クリックコンバージョンのアップロード」](https://developers.google.com/google-ads/api/docs/conversions/upload-clicks?hl=ja)

## composerでインストールする

```bash
$ composer require googleads/google-ads-php:25.0.0
```

ライブラリパッケージ：[Packagist](https://packagist.org/packages/googleads/google-ads-php)

最新は26.0.0ですが、私は[公式リファレンス「API呼び出しを行う」](https://developers.google.com/google-ads/api/docs/get-started/make-first-call?hl=ja)を参考に25.0.0を使用しました。

## 認証情報ファイルの作成

```ini
[GOOGLE_ADS]
developerToken = "*****"
loginCustomerId = "*****"

[OAUTH2]
clientId = "*****.apps.googleusercontent.com"
clientSecret = "*****"
refreshToken = "*****"
```

上記の内容で認証情報のファイルを作成し、後からこの情報を参照します。

## 使用する名前空間

```php
use Google\Ads\GoogleAds\Lib\v18\GoogleAdsClient;
use Google\Ads\GoogleAds\Lib\v18\GoogleAdsClientBuilder;
use Google\Ads\GoogleAds\v18\Services\ClickConversion;
use Google\Ads\GoogleAds\v18\Services\UploadClickConversionsRequest;
use Google\Ads\GoogleAds\V18\Services\SearchGoogleAdsRequest;
use Google\Ads\GoogleAds\v18\Services\GoogleAdsRow;
use Google\Ads\GoogleAds\v18\Services\ConversionUploadServiceClient;
use Google\Ads\GoogleAds\Util\v18\ResourceNames;
use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use Google\Auth\CredentialsLoader;
```

コンバージョンアップロードのリクエストを送るだけであれば、上記の名前空間だけでも動作を確認しております。

しかし[公式が公開している例](https://github.com/googleads/google-ads-php/blob/6f37249dcb0da6485cc38e74f5e3cc00e4400a4f/examples/Remarketing/UploadOfflineConversion.php)ではかなり厳密にチェックを行っております。

必要なものがあれば適宜追加いただけますと幸いです。

## セットアップ

```php
	protected $googleAdsClient;
	protected $customerId = *****;
	
	public function __construct()
	{
		$this->googleAdsClient = (new GoogleAdsClientBuilder())
			->fromFile(storage_path('/path/to/google_ads_php.ini'))
			->withOAuth2Credential((new OAuth2TokenBuilder())
				->fromFile(storage_path('/path/to/google_ads_php.ini'))
				->build())
			->build();
	}
```

`/path/to/google_ads_php.ini`の箇所は[認証情報ファイルの作成](#認証情報ファイルの作成)でご準備いただいたファイルを参照するようにご設定ください。

## コンバージョンアクションIDの確認

コンバージョンアクションを識別するIDが必要な為、現在のアカウントに登録されているコンバージョンアクション一覧をAPIから取得する関数です。

```php
public function getConversionActions()
{	
	// クエリを作成
	$query = "SELECT conversion_action.id, conversion_action.name FROM conversion_action";
	
	// SearchGoogleAdsRequest のリクエストオブジェクトを作成
	$request = new SearchGoogleAdsRequest([
		'customer_id' => $this->$customerId,
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
			'id' => $conversionAction->getId(),
			'name' => $conversionAction->getName()
		];
	}

	return $conversionActions;
}
```

コンバージョンアクション名が変更されてもこちらのIDは変わらない為、システムに組み込む必要はないかと存じます。

必要であればお役立てください。

## コンバージョンアクションのアップロード

```php
	public function uploadOfflineConversion($gclid, $conversion_time, $conversion_value, $conversion_action_id)
	{
		// コンバージョンのデータを作成
		$conversion = new ClickConversion([
			'gclid' => $gclid,
			'conversion_action' => ResourceNames::forConversionAction($this->customerId, $conversion_action_id),
			'conversion_date_time' => $conversion_time,
			'conversion_value' => $conversion_value,
			'currency_code' => 'JPY',
		]);

		// リクエストの作成
		$request = new UploadClickConversionsRequest([
			'customer_id' => $this->customerId,
			'conversions' => [$conversion],
			'partial_failure' => true
		]);

		// APIリクエストを送信
		$response = $this->googleAdsClient->getConversionUploadServiceClient()
			->uploadClickConversions($request);

        $result = [];

        // 部分的なエラー情報があるかチェック
        $partialFailureErrors = $response->getPartialFailureError();
        if ($partialFailureErrors) {
            $result['errors'] = $partialFailureErrors->getMessage();
        } else {
            // エラーが無ければレスポンスの詳細を取得
            foreach ($response->getResults() as $index => $uploadedConversion) {
                $result[] = [
                    'index' => $index,
                    'gclid' => $gclid,
                    'conversion_action' => $uploadedConversion->getConversionAction(),
                    'conversion_date_time' => $uploadedConversion->getConversionDateTime(),
                    'status' => 'Success'
                ];
            }
        }

		return $result;
	}
```

コンバージョンデータは入力規則がありますので以下に書き出します。

- `gclid`：string型。このコンバージョンに関連付けられたGoogleクリックID (gclid)。

- `conversion_action`：string型。このコンバージョンに関連付けられたコンバージョンアクションのリソース名。

- `conversion_date_time`：string型。コンバージョンが発生した日時。クリック時刻より後の日時である必要があり、**__タイムゾーンを指定する必要があります__**。

- `conversion_value`：double型。コンバージョンの価値、すなわち金額です。

- `currency_code`：string型。ISO 4217の3文字の通貨コードです。

**`conversion_action`の構成**

リソース名は広告アカウントのIDと[コンバージョンアクションID](#コンバージョンアクションidの確認)で構成されます。

しかしリクエストの検証では広告アカウントIDは無視され、コンバージョンアクションIDのみをコンバージョンアクションの唯一の識別子として使用しているようです。

**`conversion_date_time`の形式**

```
yyyy-mm-dd hh:mm:ss+|-hh:mm // 例：2025-02-26 15:00:00+09:00
```

GMTを入れた指定の形式にフォーマットする必要があります。

> 参照：Google Ads API [ClickConversion](https://developers.google.com/google-ads/api/reference/rpc/v18/ClickConversion)

## validateOnlyフラグ

uploadClickConversionsメソッドのリクエストパラメータの中に、validateOnlyというフラグが存在します。

```php
		$request = new UploadClickConversionsRequest([
			// 必須：広告アカウントのID
			'customer_id' => $this->customerId,

			// 必須：コンバージョンデータ
			'conversions' => [$conversion],
			
			// 必須：同一リクエスト内の他のオペレーションが
			// 　　　失敗しても処理を続行し、有効なオペレーションは実行
			// 　　　無効なオペレーションはエラーを返す
			'partial_failure' => true,

			// 任意：リクエストの検証のみを行うかの指定
			'validate_only' => true
		]);

```

こちらは検証のみ行い実行はしない指定で、validateOnlyをtrueに指定すると実際にアップロードはされずエラーのみ返却されます。

本資料作成中に気づいたパラメーターの為未検証ですが、開発時はこちらをお役立ていただくと良いかもしれません。

> 参照：Google Ads API [UploadClickConversionsRequest](https://developers.google.com/google-ads/api/reference/rpc/v18/UploadClickConversionsRequest)

## 環境

| 言語・フレームワーク | バージョン |
| ------------------ | --------- |
| Composer           | 2.8.2     |
| Docker             | 28.0.0    |
| php                | 8.3.17    |
| Apache             | 2.4.62    |
| MariaDB            | 10.5.27   |
| phpMyAdmin         | 5.2.1     |
| Laravel            | 11.41.3   |
