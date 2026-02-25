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
use OlzaLogistic\PpApi\Client\Model\Country;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class DetailsTest extends BaseTestCase
{
    public function testDetailsReturnsSuccessResult(): void
    {
        $apiJson = \json_encode([
            'success' => true,
            'code'    => 0,
            'message' => 'OK',
            'data'    => [
                'items' => [],
            ],
        ]);

        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');

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

        $apiClient = Client::useApi($url)
                           ->withAccessToken($accessToken)
                           ->withHttpClient($httpClientStub)
                           ->withRequestFactory($requestFactoryStub)
                           ->build();

        $apiParams = Params::create()
                           ->withCountry(Country::CZECHIA)
                           ->withSpedition('gls-ps')
                           ->withSpeditionId('PP123');

        $result = $apiClient->details($apiParams);

        $this->assertTrue($result->success());
    }

    public function testDetailsReturnsErrorResultOnApiFailure(): void
    {
        $errorMessage = 'Object not found';
        $apiJson = \json_encode([
            'success' => false,
            'code'    => 1,
            'message' => $errorMessage,
            'data'    => null,
        ]);

        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');

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

        $apiClient = Client::useApi($url)
                           ->withAccessToken($accessToken)
                           ->withHttpClient($httpClientStub)
                           ->withRequestFactory($requestFactoryStub)
                           ->build();

        $apiParams = Params::create()
                           ->withCountry(Country::CZECHIA)
                           ->withSpedition('gls-ps')
                           ->withSpeditionId('PP123');

        $result = $apiClient->details($apiParams);

        $this->assertFalse($result->success());
        $this->assertEquals($errorMessage, $result->getMessage());
    }

} // end of class
