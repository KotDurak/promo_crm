# OpenAPI\Client\DefaultApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiPromoCodesGet()**](DefaultApi.md#apiPromoCodesGet) | **GET** /api/promo-codes | Получить список промокодов |
| [**apiPromoCodesPurchasePost()**](DefaultApi.md#apiPromoCodesPurchasePost) | **POST** /api/promo-codes/purchase | Покупка с промокодом |
| [**apiPromoCodesRegisterPost()**](DefaultApi.md#apiPromoCodesRegisterPost) | **POST** /api/promo-codes/register | Регистрация по промокоду |
| [**apiTokenRefreshPost()**](DefaultApi.md#apiTokenRefreshPost) | **POST** /api/token/refresh | Обновление токена |


## `apiPromoCodesGet()`

```php
apiPromoCodesGet($x_api_token)
```

Получить список промокодов

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$x_api_token = 921f91c92407f7a5e8244af267a5bb428a4899a7b4bb63a29fbddeb7d8ffb50b; // string

try {
    $apiInstance->apiPromoCodesGet($x_api_token);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->apiPromoCodesGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_api_token** | **string**|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiPromoCodesPurchasePost()`

```php
apiPromoCodesPurchasePost($x_api_token, $api_promo_codes_purchase_post_request)
```

Покупка с промокодом

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$x_api_token = 921f91c92407f7a5e8244af267a5bb428a4899a7b4bb63a29fbddeb7d8ffb50b; // string
$api_promo_codes_purchase_post_request = new \OpenAPI\Client\Model\ApiPromoCodesPurchasePostRequest(); // \OpenAPI\Client\Model\ApiPromoCodesPurchasePostRequest

try {
    $apiInstance->apiPromoCodesPurchasePost($x_api_token, $api_promo_codes_purchase_post_request);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->apiPromoCodesPurchasePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_api_token** | **string**|  | |
| **api_promo_codes_purchase_post_request** | [**\OpenAPI\Client\Model\ApiPromoCodesPurchasePostRequest**](../Model/ApiPromoCodesPurchasePostRequest.md)|  | [optional] |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiPromoCodesRegisterPost()`

```php
apiPromoCodesRegisterPost($x_api_token, $api_promo_codes_register_post_request)
```

Регистрация по промокоду

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$x_api_token = 921f91c92407f7a5e8244af267a5bb428a4899a7b4bb63a29fbddeb7d8ffb50b; // string
$api_promo_codes_register_post_request = new \OpenAPI\Client\Model\ApiPromoCodesRegisterPostRequest(); // \OpenAPI\Client\Model\ApiPromoCodesRegisterPostRequest

try {
    $apiInstance->apiPromoCodesRegisterPost($x_api_token, $api_promo_codes_register_post_request);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->apiPromoCodesRegisterPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_api_token** | **string**|  | |
| **api_promo_codes_register_post_request** | [**\OpenAPI\Client\Model\ApiPromoCodesRegisterPostRequest**](../Model/ApiPromoCodesRegisterPostRequest.md)|  | [optional] |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiTokenRefreshPost()`

```php
apiTokenRefreshPost($x_api_token)
```

Обновление токена

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$x_api_token = a1dedc4ba797551f2b9a695929c3958b90853295801f0520c7000d37822adf3a; // string

try {
    $apiInstance->apiTokenRefreshPost($x_api_token);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->apiTokenRefreshPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **x_api_token** | **string**|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
