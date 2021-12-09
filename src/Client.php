<?php

namespace Develart\PpApi\Client;

use Develart\PpApi\Client\Contracts\ClientContract;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Client implements ClientContract
{
    /** ********************************************************************************************* **/

    public function __construct(ClientInterface         $httpClient,
                                RequestFactoryInterface $requestFactory,
                                string                  $accessToken)
    {
        $this->setHttpClient($httpClient);
        $this->setRequestFactory($requestFactory);
        $this->setAccessToken($accessToken);
    }

    /** ********************************************************************************************* **/

    /**
     * PP-API access token
     *
     * @var string|null
     */
    protected string $accessToken;

    public function getAccessToken(): string
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

    /** ********************************************************************************************* **/

    /**
     * Base URL for APi endpoints.
     *
     * NOTE: The value MUST NOT contain any trailing slash!
     *
     * @var string
     */
    protected const API_URL = 'https://api.posten.no/pp/v1';

    /**
     * Talks to API and returns list of PPs matching search criteria.
     *
     * @param string      $countryCode Mandatory country code (i.e. 'cz', 'hu', etc.).
     * @param string|null $spedition   (optional) Olza's spedition code (i.e. 'CP-BAL', etc.).
     * @param string|null $city        (optional) City name to narrow the search to.
     *
     * @return \Develart\PpApi\Client\Result
     */
    public function find(string  $countryCode, ?string $spedition = null,
                         ?string $city = null): Result
    {
        $queryArgs = [
            Consts::PARAM_COUNTRY => $countryCode,
        ];
        if (!empty($spedition)) {
            $queryArgs[ Consts::PARAM_SPEDITION ] = $spedition;
        }
        if (!empty($city)) {
            $queryArgs[ Consts::PARAM_CITY ] = $city;
        }

        return $this->handleHttpRequest('/pp/find', $queryArgs);
    }

    public function details(string $countryCode, string $spedition, string $id): Result
    {
        $queryArgs = [
            Consts::PARAM_COUNTRY   => $countryCode,
            Consts::PARAM_SPEDITION => $spedition,
            Consts::PARAM_ID        => $id,
        ];
        return $this->handleHttpRequest('/pp/details', $queryArgs);
    }

    /**
     * Calls API endpoint and builds proper Response instance either with returned
     * data or one indicating request failure.
     *
     * @param string     $endPoint  Endpoint to call (i.e. '/pp/find')
     * @param array|null $queryArgs Array of
     *
     * @return \Develart\PpApi\Client\Result
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

    /** ********************************************************************************************* **/

    /**
     * Constructs final request and does GET request to remote API.
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    protected function doGetRequest(string $endPoint, ?array $queryArgs = null): ResponseInterface
    {
        $uri = static::API_URL . $endPoint;
        if (!empty($queryArgs ?? [])) {
            $uri .= '?' . \http_build_query($queryArgs);
        }

        $client = $this->getHttpClient();
        $request = $this->createRequest('GET', $uri);
        return $client->sendRequest($request);
    }
}
