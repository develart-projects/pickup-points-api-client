<?php

namespace OlzaLogistic\PpApi\Client;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2021 DevelArt IV
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\Contracts\ClientContract;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class ClientBase implements ClientContract
{
    /**
     * Configures client to use specific API URL
     *
     * @param string $apiUrl Valid API URL, i.e. 'https://api.olzalogistic.com/v1'
     */
    public static function useApi(string $apiUrl): self
    {
        if (!preg_match('#^https?://#', $apiUrl)) {
            throw new \InvalidArgumentException('Invalid API URL.');
        }

        return new static($apiUrl);
    }

    /**
     * Configures client to use specific access token while talking to Pickup Points API.
     *
     * @param string $accessToken Your private access token.
     *
     * @return $this
     */
    public function withAccessToken(string $accessToken): self
    {
        if (empty(\trim($accessToken))) {
            throw new \InvalidArgumentException('Invalid API access token.');
        }

        $this->setAccessToken($accessToken);
        return $this;
    }

    /**
     * Configures Client instance to use Guzzle HTTP client.
     *
     * NOTE: Requires Guzzle package to be installed.
     */
    public function withGuzzleClient(): self
    {
        $this->assertClientNotConfigured();

        if (!\class_exists('\GuzzleHttp\Client')) {
            throw new \RuntimeException('Guzzle package not found. Install it: composer require guzzlehttp/guzzle');
        }
        $this->setHttpClient(new \GuzzleHttp\Client());
        $this->setRequestFactory(new GuzzleRequestFactory());
        return $this;
    }

    /**
     * Configures Client instance to use generic PSR-17 compatible HTTP client.
     *
     * @param ClientInterface         $httpClient     Instance of PSR-17 compatible HTTP client.
     * @param RequestFactoryInterface $requestFactory Instance of PSR-17 compatible request factory.
     */
    public function withPsrClient(ClientInterface         $httpClient,
                                  RequestFactoryInterface $requestFactory): self
    {
        $this->assertClientNotConfigured();

        $this->setHttpClient($httpClient);
        $this->setRequestFactory($requestFactory);
        return $this;
    }

    /**
     * Returns complete, ready to use PP-API Client instance.
     */
    public function get(): self
    {
        $this->seal();
        return $this;
    }

    /* ****************************************************************************************** */

    protected bool $clientInitialized = false;

    protected function seal(): void
    {
        $this->clientInitialized = true;
    }

    /**
     * Ensures Client is correctly configured. Will throw excetion if not.
     */
    protected function assertConfigurationSealed(): void
    {
        if (!$this->clientInitialized) {
            throw new \RuntimeException('Client not initialized.');
        }
    }

    protected function assertClientNotConfigured(): void
    {
        if ($this->clientInitialized) {
            throw new \RuntimeException('Client already initialized.');
        }
    }

    /* ****************************************************************************************** */

    protected function __construct(string $apiUrl)
    {
        $this->setApiUrl($apiUrl);
    }

    /* ****************************************************************************************** */

    /**
     * PP-API access token
     *
     * @var string|null
     */
    protected string $accessToken;

    protected function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Sets access token to provided value. Must be a valid, non-empty string.
     *
     * @param string|null $accessToken PP-API access token
     *
     * @return $this
     */
    protected function setAccessToken(string $accessToken): self
    {
        if (\trim($accessToken) === '') {
            throw new \RuntimeException('Invalid value of accessToken');
        }
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * Network client for API communication.
     *
     * @var \Psr\Http\Client\ClientInterface|null
     */
    protected ClientInterface $httpClient;

    protected function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    protected function setHttpClient(ClientInterface $httpClient): self
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * Returns request factory instance (PSR-17)
     *
     * @var \Psr\Http\Message\RequestFactoryInterface
     */
    protected RequestFactoryInterface $requestFactory;

    protected function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    protected function setRequestFactory(RequestFactoryInterface $requestFactory): self
    {
        $this->requestFactory = $requestFactory;
        return $this;
    }

    /**
     * Base URL for the API
     *
     * @var string
     */
    protected string $apiUrl;

    protected function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    protected function setApiUrl(string $apiUrl): self
    {
        $this->apiUrl = $apiUrl;
        return $this;
    }

    /**
     * Helper method that creates instance of Request object, set up according
     * to provided arguments.
     *
     * @param string     $method    HTTP method to call (i.e. 'GET', 'POST', etc.)
     * @param string     $uri       Target URI (ie. 'https://api.foo.com/v1/bar')
     * @param array|null $queryArgs Optional array of key-value pairs to be added
     *                              to query string prior making API request.
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function createRequest(string $method, string $uri,
                                     ?array $queryArgs = null): RequestInterface
    {
        if ($queryArgs === null) {
            $queryArgs = [];
        }

        if (!empty($queryArgs)) {
            $uri += '?' . \http_build_query($queryArgs);
        }

        $request = $this->getRequestFactory()->createRequest($method, $uri);

        if (!$request->hasHeader('User-Agent')) {
            // FIXME: make UA a class' constant.
            $request = $request->withHeader('User-Agent', 'Develart/PpApi');
        }
        return $request;
    }

    /* ****************************************************************************************** */

    /**
     * Calls API endpoint and builds proper Response instance either with returned
     * data or one indicating request failure.
     *
     * @param string     $endPoint  Endpoint to call (i.e. '/pp/find')
     * @param array|null $queryArgs Array of
     *
     * @return \OlzaLogistic\PpApi\Client\Result
     */
    protected function handleHttpRequest(string $endPoint, ?array $queryArgs): Result
    {
        try {
            $apiResponse = $this->doGetRequest($endPoint, $queryArgs);
            $result = Result::fromApiResponse($apiResponse);
        } catch (\Throwable $ex) {
            // FIXME: log the exception
            $result = Result::fromThrowable($ex);
        }

        return $result;
    }

    /* ****************************************************************************************** */

    /** @var string */
    protected const KEY_ACCESS_TOKEN = 'access_token';

    /**
     * Constructs final request and does GET request to remote API.
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    protected function doGetRequest(string $endPoint, ?array $queryArgs = null): ResponseInterface
    {
        if ($this->accessToken !== null) {
            if (!\array_key_exists(static::KEY_ACCESS_TOKEN, $queryArgs)) {
                $queryArgs[ static::KEY_ACCESS_TOKEN ] = $this->getAccessToken();
            }
        }

        $uri = $this->getApiUrl() . $endPoint;
        if (!empty($queryArgs ?? [])) {
            $uri .= '?' . \http_build_query($queryArgs);
        }

        $client = $this->getHttpClient();
        $request = $this->createRequest('GET', $uri);
        return $client->sendRequest($request);
    }

} // end of class
