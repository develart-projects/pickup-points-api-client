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

use OlzaLogistic\PpApi\Client\Client;
use OlzaLogistic\PpApi\Client\Consts\Route;
use OlzaLogistic\PpApi\Client\Method;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class RawRequestTest extends BaseTestCase
{
    protected function buildSuccessApiJson(?array $data = null): string
    {
        return (string)\json_encode([
            'success' => true,
            'code'    => 0,
            'message' => 'OK',
            'data'    => $data,
        ]);
    }

    protected function buildClientWithResponse(string $url, string $accessToken, string $apiJson): Client
    {
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
                     ->build();
    }

    public function testRawRequestWithNullParamsCreatesDefaultParams(): void
    {
        // when $apiParams is null, rawRequest() must auto-create Params::create() internally
        $apiJson = $this->buildSuccessApiJson();
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');

        $apiClient = $this->buildClientWithResponse($url, $accessToken, $apiJson);

        $result = $apiClient->rawRequest(Method::GET, Route::CONFIG, null);

        $this->assertTrue($result->success());
    }

    public function testRawRequestWithExplicitParams(): void
    {
        $apiJson = $this->buildSuccessApiJson(['key' => 'value']);
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');

        $apiClient = $this->buildClientWithResponse($url, $accessToken, $apiJson);

        $apiParams = Params::create();
        $result = $apiClient->rawRequest(Method::GET, Route::CONFIG, $apiParams);

        $this->assertTrue($result->success());
        $this->assertNotNull($result->getData());
    }

} // end of class
