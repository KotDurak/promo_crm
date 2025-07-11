<?php
/**
 * DefaultApi
 * PHP version 7.4
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * PROMO CRM API
 *
 * API для работы с промокодами
 *
 * The version of the OpenAPI document: 1.0.0
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.2.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace OpenAPI\Client\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use OpenAPI\Client\ApiException;
use OpenAPI\Client\Configuration;
use OpenAPI\Client\HeaderSelector;
use OpenAPI\Client\ObjectSerializer;

/**
 * DefaultApi Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class DefaultApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     * @param int             $hostIndex (Optional) host index to select the list of hosts if defined in the OpenAPI spec
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null,
        $hostIndex = 0
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex = $hostIndex;
    }

    /**
     * Set the host index
     *
     * @param int $hostIndex Host index (required)
     */
    public function setHostIndex($hostIndex): void
    {
        $this->hostIndex = $hostIndex;
    }

    /**
     * Get the host index
     *
     * @return int Host index
     */
    public function getHostIndex()
    {
        return $this->hostIndex;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation apiPromoCodesGet
     *
     * Получить список промокодов
     *
     * @param  string $x_api_token x_api_token (required)
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function apiPromoCodesGet($x_api_token)
    {
        $this->apiPromoCodesGetWithHttpInfo($x_api_token);
    }

    /**
     * Operation apiPromoCodesGetWithHttpInfo
     *
     * Получить список промокодов
     *
     * @param  string $x_api_token (required)
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function apiPromoCodesGetWithHttpInfo($x_api_token)
    {
        $request = $this->apiPromoCodesGetRequest($x_api_token);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            
            }
            throw $e;
        }
    }

    /**
     * Operation apiPromoCodesGetAsync
     *
     * Получить список промокодов
     *
     * @param  string $x_api_token (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function apiPromoCodesGetAsync($x_api_token)
    {
        return $this->apiPromoCodesGetAsyncWithHttpInfo($x_api_token)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation apiPromoCodesGetAsyncWithHttpInfo
     *
     * Получить список промокодов
     *
     * @param  string $x_api_token (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function apiPromoCodesGetAsyncWithHttpInfo($x_api_token)
    {
        $returnType = '';
        $request = $this->apiPromoCodesGetRequest($x_api_token);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'apiPromoCodesGet'
     *
     * @param  string $x_api_token (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function apiPromoCodesGetRequest($x_api_token)
    {

        // verify the required parameter 'x_api_token' is set
        if ($x_api_token === null || (is_array($x_api_token) && count($x_api_token) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_api_token when calling apiPromoCodesGet'
            );
        }

        $resourcePath = '/api/promo-codes';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_api_token !== null) {
            $headerParams['X-API-TOKEN'] = ObjectSerializer::toHeaderValue($x_api_token);
        }



        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation apiPromoCodesPurchasePost
     *
     * Покупка с промокодом
     *
     * @param  string $x_api_token x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesPurchasePostRequest $api_promo_codes_purchase_post_request api_promo_codes_purchase_post_request (optional)
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function apiPromoCodesPurchasePost($x_api_token, $api_promo_codes_purchase_post_request = null)
    {
        $this->apiPromoCodesPurchasePostWithHttpInfo($x_api_token, $api_promo_codes_purchase_post_request);
    }

    /**
     * Operation apiPromoCodesPurchasePostWithHttpInfo
     *
     * Покупка с промокодом
     *
     * @param  string $x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesPurchasePostRequest $api_promo_codes_purchase_post_request (optional)
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function apiPromoCodesPurchasePostWithHttpInfo($x_api_token, $api_promo_codes_purchase_post_request = null)
    {
        $request = $this->apiPromoCodesPurchasePostRequest($x_api_token, $api_promo_codes_purchase_post_request);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            
            }
            throw $e;
        }
    }

    /**
     * Operation apiPromoCodesPurchasePostAsync
     *
     * Покупка с промокодом
     *
     * @param  string $x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesPurchasePostRequest $api_promo_codes_purchase_post_request (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function apiPromoCodesPurchasePostAsync($x_api_token, $api_promo_codes_purchase_post_request = null)
    {
        return $this->apiPromoCodesPurchasePostAsyncWithHttpInfo($x_api_token, $api_promo_codes_purchase_post_request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation apiPromoCodesPurchasePostAsyncWithHttpInfo
     *
     * Покупка с промокодом
     *
     * @param  string $x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesPurchasePostRequest $api_promo_codes_purchase_post_request (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function apiPromoCodesPurchasePostAsyncWithHttpInfo($x_api_token, $api_promo_codes_purchase_post_request = null)
    {
        $returnType = '';
        $request = $this->apiPromoCodesPurchasePostRequest($x_api_token, $api_promo_codes_purchase_post_request);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'apiPromoCodesPurchasePost'
     *
     * @param  string $x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesPurchasePostRequest $api_promo_codes_purchase_post_request (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function apiPromoCodesPurchasePostRequest($x_api_token, $api_promo_codes_purchase_post_request = null)
    {

        // verify the required parameter 'x_api_token' is set
        if ($x_api_token === null || (is_array($x_api_token) && count($x_api_token) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_api_token when calling apiPromoCodesPurchasePost'
            );
        }


        $resourcePath = '/api/promo-codes/purchase';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_api_token !== null) {
            $headerParams['X-API-TOKEN'] = ObjectSerializer::toHeaderValue($x_api_token);
        }



        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($api_promo_codes_purchase_post_request)) {
            if ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($api_promo_codes_purchase_post_request));
            } else {
                $httpBody = $api_promo_codes_purchase_post_request;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation apiPromoCodesRegisterPost
     *
     * Регистрация по промокоду
     *
     * @param  string $x_api_token x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesRegisterPostRequest $api_promo_codes_register_post_request api_promo_codes_register_post_request (optional)
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function apiPromoCodesRegisterPost($x_api_token, $api_promo_codes_register_post_request = null)
    {
        $this->apiPromoCodesRegisterPostWithHttpInfo($x_api_token, $api_promo_codes_register_post_request);
    }

    /**
     * Operation apiPromoCodesRegisterPostWithHttpInfo
     *
     * Регистрация по промокоду
     *
     * @param  string $x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesRegisterPostRequest $api_promo_codes_register_post_request (optional)
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function apiPromoCodesRegisterPostWithHttpInfo($x_api_token, $api_promo_codes_register_post_request = null)
    {
        $request = $this->apiPromoCodesRegisterPostRequest($x_api_token, $api_promo_codes_register_post_request);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            
            }
            throw $e;
        }
    }

    /**
     * Operation apiPromoCodesRegisterPostAsync
     *
     * Регистрация по промокоду
     *
     * @param  string $x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesRegisterPostRequest $api_promo_codes_register_post_request (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function apiPromoCodesRegisterPostAsync($x_api_token, $api_promo_codes_register_post_request = null)
    {
        return $this->apiPromoCodesRegisterPostAsyncWithHttpInfo($x_api_token, $api_promo_codes_register_post_request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation apiPromoCodesRegisterPostAsyncWithHttpInfo
     *
     * Регистрация по промокоду
     *
     * @param  string $x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesRegisterPostRequest $api_promo_codes_register_post_request (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function apiPromoCodesRegisterPostAsyncWithHttpInfo($x_api_token, $api_promo_codes_register_post_request = null)
    {
        $returnType = '';
        $request = $this->apiPromoCodesRegisterPostRequest($x_api_token, $api_promo_codes_register_post_request);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'apiPromoCodesRegisterPost'
     *
     * @param  string $x_api_token (required)
     * @param  \OpenAPI\Client\Model\ApiPromoCodesRegisterPostRequest $api_promo_codes_register_post_request (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function apiPromoCodesRegisterPostRequest($x_api_token, $api_promo_codes_register_post_request = null)
    {

        // verify the required parameter 'x_api_token' is set
        if ($x_api_token === null || (is_array($x_api_token) && count($x_api_token) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_api_token when calling apiPromoCodesRegisterPost'
            );
        }


        $resourcePath = '/api/promo-codes/register';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_api_token !== null) {
            $headerParams['X-API-TOKEN'] = ObjectSerializer::toHeaderValue($x_api_token);
        }



        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($api_promo_codes_register_post_request)) {
            if ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($api_promo_codes_register_post_request));
            } else {
                $httpBody = $api_promo_codes_register_post_request;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation apiTokenRefreshPost
     *
     * Обновление токена
     *
     * @param  string $x_api_token x_api_token (required)
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function apiTokenRefreshPost($x_api_token)
    {
        $this->apiTokenRefreshPostWithHttpInfo($x_api_token);
    }

    /**
     * Operation apiTokenRefreshPostWithHttpInfo
     *
     * Обновление токена
     *
     * @param  string $x_api_token (required)
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function apiTokenRefreshPostWithHttpInfo($x_api_token)
    {
        $request = $this->apiTokenRefreshPostRequest($x_api_token);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            
            }
            throw $e;
        }
    }

    /**
     * Operation apiTokenRefreshPostAsync
     *
     * Обновление токена
     *
     * @param  string $x_api_token (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function apiTokenRefreshPostAsync($x_api_token)
    {
        return $this->apiTokenRefreshPostAsyncWithHttpInfo($x_api_token)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation apiTokenRefreshPostAsyncWithHttpInfo
     *
     * Обновление токена
     *
     * @param  string $x_api_token (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function apiTokenRefreshPostAsyncWithHttpInfo($x_api_token)
    {
        $returnType = '';
        $request = $this->apiTokenRefreshPostRequest($x_api_token);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'apiTokenRefreshPost'
     *
     * @param  string $x_api_token (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function apiTokenRefreshPostRequest($x_api_token)
    {

        // verify the required parameter 'x_api_token' is set
        if ($x_api_token === null || (is_array($x_api_token) && count($x_api_token) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_api_token when calling apiTokenRefreshPost'
            );
        }

        $resourcePath = '/api/token/refresh';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // header params
        if ($x_api_token !== null) {
            $headerParams['X-API-TOKEN'] = ObjectSerializer::toHeaderValue($x_api_token);
        }



        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
