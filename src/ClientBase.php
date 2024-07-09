<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client;

use OlzaLogistic\PpApi\Client\Contracts\ClientContract;
use OlzaLogistic\PpApi\Client\Exception\AccessDeniedException;
use OlzaLogistic\PpApi\Client\Exception\ClientAlreadyInitializedException;
use OlzaLogistic\PpApi\Client\Exception\ClientNotSealedException;
use OlzaLogistic\PpApi\Client\Exception\MethodFailedException;
use OlzaLogistic\PpApi\Client\Exception\ObjectNotFoundException;
use OlzaLogistic\PpApi\Client\Util\Json;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class ClientBase implements ClientContract
{
    /**
     * Configures the client to engage with a Pickup Point API at the provided URL.
     *
     * @param string $apiUrl Valid API URL, i.e. 'https://api.olzalogistic.com/v1'
     */
    public static function useApi(string $apiUrl): self
    {
        return new static($apiUrl);
    }

    /**
     * Configures the client to utilize a specific access token when interacting with the Pickup
     * Points API.
     *
     * @param string $accessToken Your private access token.
     */
    public function withAccessToken(string $accessToken): self
    {
        return $this->setAccessToken($accessToken);
    }

    /**
     * Specifies the User-Agent string for all HTTP API requests.
     *
     * @param string $userAgent User agent string.
     */
    public function withUserAgent(string $userAgent): self
    {
        return $this->setUserAgent($userAgent);
    }

    /**
     * Configures a PSR-18 compatible instance of an HTTP client implementation.
     *
     * @param ClientInterface $httpClient Instance of PSR-18 compatible HTTP client.
     */
    public function withHttpClient(ClientInterface $httpClient): self
    {
        $this->assertClientNotConfigured();

        return $this->setHttpClient($httpClient);
    }


    /**
     * Configures a PSR-17 compatible request factory instance to work with the HTTP client.
     *
     * @param RequestFactoryInterface $requestFactory Instance of PSR-17 compatible request factory.
     */
    public function withRequestFactory(RequestFactoryInterface $requestFactory): self
    {
        $this->assertClientNotConfigured();

        return $this->setRequestFactory($requestFactory);
    }

    public function withStreamFactory(StreamFactoryInterface $streamFactory): self
    {
        $this->assertClientNotConfigured();

        return $this->setStreamFactory($streamFactory);
    }

    /**
     * Configures the client to throw an exception in case of any API connection failure.
     * Beneficial for an "exception-driven" coding approach.
     */
    public function throwOnError(): self
    {
        return $this->setThrowOnError(true);
    }

    /**
     * Returns complete, ready to use PP-API Client instance.
     */
    public function build(): self
    {
        $this->seal();
        return $this;
    }

    /* ****************************************************************************************** */

    /**
     * Indicates if client configuration phase is completed.
     *
     * @var bool
     */
    protected $isClientInitialized = false;

    /**
     * Disallows further configuration of the client. Once seal() is invoked, no subsequent changes
     * to the client are permitted.
     */
    protected function seal(): void
    {
        $this->isClientInitialized = true;
    }

    /**
     * Verifies the client's configuration is correct. An exception will be thrown if it's not.
     */
    protected function assertConfigurationSealed(): void
    {
        if (!$this->isClientInitialized) {
            throw new ClientNotSealedException();
        }
    }

    /**
     * Ensures the client has not been configured yet, allowing all configuration methods to be
     * executed safely.
     */
    protected function assertClientNotConfigured(): void
    {
        if ($this->isClientInitialized) {
            throw new ClientAlreadyInitializedException();
        }
    }

    /* ****************************************************************************************** */

    final protected function __construct(string $apiUrl)
    {
        $this->setApiUrl($apiUrl);
    }

    /* ****************************************************************************************** */

    /**
     * PP-API access token
     *
     * @var string
     */
    protected $accessToken;

    protected function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Sets access token to provided value. Must be a valid, non-empty string.
     *
     * @param string $accessToken PP-API access token.
     */
    protected function setAccessToken(string $accessToken): self
    {
        if (\trim($accessToken) === '') {
            throw new \InvalidArgumentException('Invalid value of accessToken');
        }
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * Network client for API communication.
     *
     * @var ClientInterface
     */
    protected $httpClient;

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
    protected $requestFactory;

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
     * Stream factory instance (PSR-17) for methods that are documented to need it (most do not).
     *
     * @var \Psr\Http\Message\StreamFactoryInterface
     */
    protected $streamFactory;

    protected function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    protected function setStreamFactory(StreamFactoryInterface $streamFactory): self
    {
        $this->streamFactory = $streamFactory;
        return $this;
    }

    /**
     * Base URL for the API
     *
     * @var string
     */
    protected $apiUrl;

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
     * User Agent string for API requests
     *
     * @var string
     */
    protected $userAgent = 'Olza Logistic/PpApiClient';

    protected function getUserAgent(): string
    {
        return $this->userAgent;
    }

    protected function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @var bool
     */
    protected $throwOnError = false;

    protected function getThrowOnError(): bool
    {
        return $this->throwOnError;
    }

    protected function setThrowOnError(bool $throwOnError): self
    {
        $this->throwOnError = $throwOnError;
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
     */
    protected function createRequest(string $method, string $uri,
                                     ?array $queryArgs = null): RequestInterface
    {
        $queryArgs = $queryArgs ?? [];
        if (!empty($queryArgs)) {
            $uri .= '?' . \http_build_query($queryArgs);
        }

        $request = $this->getRequestFactory()->createRequest($method, $uri);
        if (!$request->hasHeader('User-Agent')) {
            /**
             * Some static analyzers apparently believe the line
             * below is unreachable. Most likely it's because
             * the dummy implementation of invoked method
             * is used as reference (and it just throws).
             */
            $request = $request->withHeader('User-Agent', $this->getUserAgent());
        }
        return $request;
    }

    /* ****************************************************************************************** */

    /**
     * Calls API endpoint and builds proper Response instance either with returned
     * data or one indicating request failure.
     *
     * @param string   $httpMethod              HTTP method to use (see Method class for consts)
     * @param string   $endPoint                Endpoint to call (i.e. '/pp/find')
     * @param Params   $apiParams               Params container with valid API configuration
     * @param callable $processResponseCallback Callback that will be called to process response
     *                                          data and produce final Result object.
     *
     * @throws MethodFailedException If API call failed and throwOnError is set to TRUE.
     * @throws ObjectNotFoundException If requested object was not found.
     * @throws AccessDeniedException If access to requested object was denied.
     *
     * @throws \InvalidArgumentException If $endPoint does not start with "/" character.
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface If an error happens while processing the
     *                                                   request by the PSR HTTP client.
     */
    protected function handleHttpRequest(string   $httpMethod,
                                         string   $endPoint,
                                         Params   $apiParams,
                                         callable $processResponseCallback): Result
    {
        try {
            $endPoint = \trim($endPoint);
            $this->assertValidEndpointPart($endPoint);
            $uri = $this->getApiUrl() . $endPoint;

            $queryParams = $apiParams->getQueryParams();
            $apiParams->withAccessToken($this->accessToken);
            $uri .= '?' . $queryParams->toQueryString();

            $client = $this->getHttpClient();
            $request = $this->createRequest($httpMethod, $uri);


            $postParams = $apiParams->getPostParams();
            if ($postParams->hasJson()) {
                // Body payload is supported for specific methods only.
                $allowedMethod = [
                    Method::POST,
                    Method::PUT,
                ];
                if (!\in_array($httpMethod, $allowedMethod, true)) {
                    $exMsg = \sprintf('Payload not supported for method: %s', $httpMethod);
                    throw new MethodFailedException($exMsg, ApiCode::INVALID_ARGUMENTS);
                }
                $postPayload = $postParams->getJson();
                $body = $this->getStreamFactory()->createStream(Json::encode($postPayload));
                $request = $request->withBody($body);
            }

            $apiResponse = $client->sendRequest($request);
            /**
             * Some static analyzers apparently believe the line below is unreachable. Most likely
             * it's because the dummy implementation of invoked method is used as reference (and it
             * just throws an exception).
             *
             * @var Result $result
             */
            $result = $processResponseCallback($apiResponse);
        } catch (\Throwable $ex) {
            $result = Result::fromThrowable($ex);
        }

        if (!$result->success() && $this->getThrowOnError()) {
            switch ($result->getCode()) {
                case ApiCode::ERROR_OBJECT_NOT_FOUND:
                    $ex = new ObjectNotFoundException();
                    break;
                case ApiCode::ERROR_ACCESS_DENIED:
                    $ex = new AccessDeniedException();
                    break;
                default:
                    $ex = new MethodFailedException($result->getMessage(), $result->getCode());
                    break;
            }
            throw $ex;
        }

        return $result;
    }

    /* ****************************************************************************************** */

    /**
     * Validates endpoint part to ensure it meets API requirements.
     *
     * @param string $endPoint Endpoint part to validate.
     *
     * @throws \InvalidArgumentException If endpoint part contains not allowed characters or is
     *                                   invalid in any other way.
     */
    protected function assertValidEndpointPart(string $endPoint): void
    {
        $endPoint = \trim($endPoint);
        if ($endPoint === '') {
            throw new \InvalidArgumentException('Endpoint string must not be empty.');
        }
        if (\substr($endPoint, 0, 1) !== '/') {
            throw new \InvalidArgumentException('Endpoint must not start with "/" character.');
        }
        if (\substr($endPoint, -1) === '?') {
            throw new \InvalidArgumentException('Endpoint must not end with "?" character.');
        }
    }

    /* ****************************************************************************************** */

} // end of class
