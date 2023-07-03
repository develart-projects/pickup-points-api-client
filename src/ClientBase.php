<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client;

use OlzaLogistic\PpApi\Client\Contracts\ClientContract;
use OlzaLogistic\PpApi\Client\Exception\MethodFailedException;
use OlzaLogistic\PpApi\Client\Extras\GuzzleRequestFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

abstract class  ClientBase implements ClientContract
{
    /**
     * Configures client to use specific API URL
     *
     * @param string $apiUrl Valid API URL, i.e. 'https://api.olzalogistic.com/v1'
     */
    public static function useApi(string $apiUrl): self
    {
        return new static($apiUrl);
    }

    /**
     * Configures client to use specific access token while talking to Pickup Points API.
     *
     * @param string $accessToken Your private access token.
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
     * Sets User Agent string to be used with all the API requests.
     *
     * @param string $userAgent User agent string.
     */
    public function withUserAgent(string $userAgent): self
    {
        $this->setUserAgent($userAgent);
        return $this;
    }

    /**
     * Configures Client instance to use Guzzle HTTP client.
     *
     * NOTE: Requires Guzzle package to be installed.
     */
    public function withGuzzleHttpClient(): self
    {
        $this->assertClientNotConfigured();

        // NOTE: do NOT move Guzzle reference out of this method! This code is OPTIONAL and
        // if you "optimize" by i.e. adding "use" instead, then instantiation of this
        // class will be Guzzle dependent and will simply fail if there's no Guzzle dependency.
        /** @noinspection ClassConstantCanBeUsedInspection */
        $httpClientClass = '\GuzzleHttp\Client';

        if (!\class_exists($httpClientClass)) {
            throw new \RuntimeException('Guzzle HTTP client not found. See library docs for assistance.');
        }

        $this->setHttpClient(new $httpClientClass());
        $this->setRequestFactory(new GuzzleRequestFactory());
        return $this;
    }

    /**
     * Configures Client instance to use Symfony's PSR18 HTTP client.
     *
     * NOTE: Requires Symfony HTTP client and support packages to be installed.
     */
    public function withSymfonyHttpClient(): self
    {
        $this->assertClientNotConfigured();

        // NOTE: do NOT move Symfony reference out of this method! This code is OPTIONAL and
        // if you "optimize" by i.e. adding "use" instead, then instantiation of this
        // class will be Symfony client dependent and will simply fail if there's no Symfony
        // HTTP client dependency.
        /** @noinspection ClassConstantCanBeUsedInspection */
        $httpClientClass = '\Symfony\Component\HttpClient\Psr18Client';

        if (!\class_exists($httpClientClass)) {
            throw new \RuntimeException('Symfony HTTP client not found. See library docs for assistance.');
        }

        $client = new $httpClientClass();
        $this->setHttpClient($client);
        $this->setRequestFactory($client);

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
     * Configures client to throw exception when any API connection failure happened.
     * Useful for "exception driven" code approach.
     */
    public function throwOnError(): self
    {
        $this->setThrowOnError(true);
        return $this;
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
     */
    protected bool $isClientInitialized = false;

    /**
     * Closes ability to further configure the client. Once seal() is called no further
     * changes to the client are allowed.
     */
    protected function seal(): void
    {
        $this->isClientInitialized = true;
    }

    /**
     * Ensures Client is correctly configured. Will throw exception if not.
     */
    protected function assertConfigurationSealed(): void
    {
        if (!$this->isClientInitialized) {
            throw new \RuntimeException('Client not initialized.');
        }
    }

    /**
     * Ensures client is not yet configured and all configuration methods can safely be executed.
     */
    protected function assertClientNotConfigured(): void
    {
        if ($this->isClientInitialized) {
            throw new \RuntimeException('Client already initialized.');
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
     */
    protected string $accessToken;

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
            throw new \RuntimeException('Invalid value of accessToken');
        }
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * Network client for API communication.
     *
     * @var \Psr\Http\Client\ClientInterface
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
     * User Agent string for API requests
     */
    protected string $userAgent = 'Olza Logistic/PpApiClient';

    protected function getUserAgent(): string
    {
        return $this->userAgent;
    }

    protected function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;
        return $this;
    }


    protected bool $throwOnError = false;

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
        $queryArgs ??= [];
        if (!empty($queryArgs)) {
            $uri .= '?' . \http_build_query($queryArgs);
        }

        $request = $this->getRequestFactory()->createRequest($method, $uri);
        if (!$request->hasHeader('User-Agent')) {
            /**
             * Some static analizers apparently believe the line
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
     * @param string      $endPoint                Endpoint to call (i.e. '/pp/find')
     * @param Params|null $apiParams               Instance of Params container with valid API params.
     * @param callable    $processResponseCallback Callback that will be called to map response data
     *                                             to Result object.
     *
     * @throws MethodFailedException
     */
    protected function handleHttpRequest(string   $endPoint, ?Params $apiParams,
                                         callable $processResponseCallback): Result
    {
        try {
            $uri = $this->getApiUrl() . $endPoint;
            if ($apiParams !== null) {
                $apiParams->withAccessToken($this->accessToken);
                $uri .= '?' . $apiParams->toQueryString();
            }

            $client = $this->getHttpClient();
            $request = $this->createRequest('GET', $uri);
            $apiResponse = $client->sendRequest($request);
            /**
             * Some static analyzers apparently believe the line  below is unreachable. Most likely
             * it's because the dummy implementation of invoked method is used as reference (and it
             * just throws).
             *
             * @var Result $result
             */
            $result = $processResponseCallback($apiResponse);
        } catch (\Throwable $ex) {
            // FIXME: log the exception
            $result = Result::fromThrowable($ex);
        }

        if (!$result->success() && $this->getThrowOnError()) {
            throw new MethodFailedException($result->getMessage());
        }

        return $result;
    }

    /* ****************************************************************************************** */

} // end of class
