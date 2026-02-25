<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Jozef Liška <jozef.liska (#) develart (.) cz>
 * @copyright 2026 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Endpoint;

use OlzaLogistic\PpApi\Client\ApiCode;
use OlzaLogistic\PpApi\Client\Client;
use OlzaLogistic\PpApi\Client\Consts\Route;
use OlzaLogistic\PpApi\Client\Exception\AccessDeniedException;
use OlzaLogistic\PpApi\Client\Exception\MethodFailedException;
use OlzaLogistic\PpApi\Client\Exception\ObjectNotFoundException;
use OlzaLogistic\PpApi\Client\Method;
use OlzaLogistic\PpApi\Client\Params;

class HttpRequestTest extends RawRequestTest
{
    protected function buildErrorApiJson(int $code, string $message): string
    {
        return (string)\json_encode([
            'success' => false,
            'code'    => $code,
            'message' => $message,
            'data'    => null,
        ]);
    }

    protected function buildClientWithThrowingHttpClient(string $url, string $accessToken): Client
    {
        $requestStub = $this->createStub(DummyRequest::class);
        $requestStub->method('withHeader')->willReturn($requestStub);

        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $requestFactoryStub->method('createRequest')->willReturn($requestStub);

        $httpClientStub = $this->createStub(DummyHttpClient::class);
        $httpClientStub->method('sendRequest')->willThrowException(new \RuntimeException('Connection error'));

        return Client::useApi($url)
                     ->withAccessToken($accessToken)
                     ->withHttpClient($httpClientStub)
                     ->withRequestFactory($requestFactoryStub)
                     ->build();
    }

    protected function buildClientWithErrorResponseAndThrowOnError(string $url, string $accessToken, string $apiJson): Client {
        $streamIfaceStub = $this->createStub(DummyStreamInterface::class);
        $streamIfaceStub->method('getContents')->willReturn($apiJson);

        $responseStub = $this->createStub(DummyResponse::class);
        $responseStub->method('getBody')->willReturn($streamIfaceStub);
        $responseStub->method('getStatusCode')->willReturn(200);

        $requestStub = $this->createStub(DummyRequest::class);
        $requestStub->method('withHeader')->willReturn($requestStub);

        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $requestFactoryStub->method('createRequest')->willReturn($requestStub);

        $httpClientStub = $this->createStub(DummyHttpClient::class);
        $httpClientStub->method('sendRequest')->willReturn($responseStub);

        return Client::useApi($url)
                     ->withAccessToken($accessToken)
                     ->withHttpClient($httpClientStub)
                     ->withRequestFactory($requestFactoryStub)
                     ->throwOnError()
                     ->build();
    }

    protected function buildClientWithResponseForPost(string $url, string $accessToken, string $apiJson): Client
    {
        $bodyStub = $this->createStub(DummyStreamInterface::class);

        $streamIfaceStub = $this->createStub(DummyStreamInterface::class);
        $streamIfaceStub->method('getContents')->willReturn($apiJson);

        $responseStub = $this->createStub(DummyResponse::class);
        $responseStub->method('getBody')->willReturn($streamIfaceStub);
        $responseStub->method('getStatusCode')->willReturn(200);

        $requestStub = $this->createStub(DummyRequest::class);
        $requestStub->method('withHeader')->willReturn($requestStub);
        $requestStub->method('withBody')->willReturn($requestStub);
        $requestStub->method('getMethod')->willReturn(Method::POST);

        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $requestFactoryStub->method('createRequest')->willReturn($requestStub);

        $httpClientStub = $this->createStub(DummyHttpClient::class);
        $httpClientStub->method('sendRequest')->willReturn($responseStub);

        $streamFactoryStub = $this->createStub(DummyStreamFactory::class);
        $streamFactoryStub->method('createStream')->willReturn($bodyStub);

        return Client::useApi($url)
                     ->withAccessToken($accessToken)
                     ->withHttpClient($httpClientStub)
                     ->withRequestFactory($requestFactoryStub)
                     ->withStreamFactory($streamFactoryStub)
                     ->build();
    }

    /* ****************************************************************************************** */

    public function testHandleHttpRequestCatchesThrowable(): void
    {
        // when sendRequest() throws, the exception is caught and wrapped in an error Result
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');

        $apiClient = $this->buildClientWithThrowingHttpClient($url, $accessToken);
        $result = $apiClient->rawRequest(Method::GET, Route::CONFIG, null);

        $this->assertFalse($result->success());
    }

    public function testHandleHttpRequestThrowsObjectNotFoundException(): void
    {
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');
        $apiJson = $this->buildErrorApiJson(ApiCode::ERROR_OBJECT_NOT_FOUND, 'Not found');

        $apiClient = $this->buildClientWithErrorResponseAndThrowOnError($url, $accessToken, $apiJson);

        $this->expectException(ObjectNotFoundException::class);
        $apiClient->rawRequest(Method::GET, Route::CONFIG, null);
    }

    public function testHandleHttpRequestThrowsAccessDeniedException(): void
    {
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');
        $apiJson = $this->buildErrorApiJson(ApiCode::ERROR_ACCESS_DENIED, 'Access denied');

        $apiClient = $this->buildClientWithErrorResponseAndThrowOnError($url, $accessToken, $apiJson);

        $this->expectException(AccessDeniedException::class);
        $apiClient->rawRequest(Method::GET, Route::CONFIG, null);
    }

    public function testHandleHttpRequestThrowsMethodFailedException(): void
    {
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');
        $apiJson = $this->buildErrorApiJson(ApiCode::INVALID_ARGUMENTS, 'Invalid arguments');

        $apiClient = $this->buildClientWithErrorResponseAndThrowOnError($url, $accessToken, $apiJson);

        $this->expectException(MethodFailedException::class);
        $apiClient->rawRequest(Method::GET, Route::CONFIG, null);
    }

    /* ****************************************************************************************** */

    public function testCreatePostPayloadWithPostMethod(): void
    {
        $apiJson = $this->buildSuccessApiJson();
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');

        $apiClient = $this->buildClientWithResponseForPost($url, $accessToken, $apiJson);

        $params = Params::create()->withPostPayload(['key' => 'value']);
        $result = $apiClient->rawRequest(Method::POST, Route::CONFIG, $params);

        $this->assertTrue($result->success());
    }

    public function testCreatePostPayloadReturnsErrorOnInvalidMethod(): void
    {
        // payload with GET method is not allowed
        $apiJson = $this->buildSuccessApiJson();
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');

        $apiClient = $this->buildClientWithResponse($url, $accessToken, $apiJson);

        $params = Params::create()->withPostPayload(['key' => 'value']);
        $result = $apiClient->rawRequest(Method::GET, Route::CONFIG, $params);

        $this->assertFalse($result->success());
    }

} // end of class
