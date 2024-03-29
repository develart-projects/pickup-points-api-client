<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Endpoint;

use OlzaLogistic\PpApi\Client\ApiResponse;
use OlzaLogistic\PpApi\Client\Client;
use OlzaLogistic\PpApi\Client\Model\Country;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use OlzaLogistic\PpApi\Client\Util\Json;

class ConfigTest extends BaseTestCase
{
    /**
     * Tests integration with Guzzle HTTP client
     */
    public function testConfig(): void
    {
        $apiJsonConfigResponse = '
            {
              "success": true,
              "code": 0,
              "message": "OK",
              "data": {
                "speditions": {
                  "cp-bal": {
                    "code": "cp-bal"
                  },
                  "gls-ps": {
                    "code": "gls-ps"
                  },
                  "zas": {
                    "code": "zas"
                  },
                  "ppl-ps": {
                    "code": "ppl-ps"
                  },
                  "bmcg-int-pp": {
                    "code": "bmcg-int-pp"
                  }
                }
              }
            }
        ';

        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');

        $json = Json::decode($apiJsonConfigResponse);
        $this->assertSuccessResponse($json);
        $jsonData = $json[ApiResponse::KEY_DATA];
        $this->assertNotNull($jsonData);

        $streamIfaceStub = $this->createStub(DummyStreamInterface::class);
        $streamIfaceStub->method('getContents')->willReturn($apiJsonConfigResponse);

        $responseStub = $this->createStub(DummyResponse::class);
        $responseStub->method('getBody')->willReturn($streamIfaceStub);
        // FIXME: use const instead of 200 (i.e.  teapot-php/status-code package (--dev)?
        $responseStub->method('getStatusCode')->willReturn(200);

        $requestStub = $this->createStub(DummyRequest::class);
        $requestStub->method('withHeader')->willReturn($requestStub);

        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $requestFactoryStub->method('createRequest')->willReturn($requestStub);

        // Create a mock for the HttpClient class
        $httpClientStub = $this->createStub(DummyHttpClient::class);
        $httpClientStub->method('sendRequest')->willReturn($responseStub);

        $apiClient = Client::useApi($url)
                           ->withAccessToken($accessToken)
                           ->withHttpClient($httpClientStub)
                           ->withRequestFactory($requestFactoryStub)
                           ->build();

        $apiParams = Params::create()->withCountry(Country::CZECHIA);

        // Call the method
        $result = $apiClient->config($apiParams);
        /** @var \OlzaLogistic\PpApi\Client\ConfigData $configData */
        $configData = $result->getData();
        $this->assertNotNull($configData);

//        $configItems = $configData->getConfigItems();
//        $this->assertNotEmpty($configItems);
//        $this->assertArrayEquals($configItems, $json[ ApiResponse::KEY_DATA ][ ApiResponse::KEY_CONFIG ]);

        $speditions = $configData->getSpeditions();
        $this->assertNotEmpty($speditions);

        $returnedSpeditionCodes = \array_keys($speditions);
        $this->assertArrayEquals(\array_keys($jsonData[ApiResponse::KEY_SPEDITIONS]), $returnedSpeditionCodes);

        foreach ($speditions as $spedCode => $spedition) {
            /** @var \OlzaLogistic\PpApi\Client\Model\Spedition $spedition */

            $i = $jsonData[ApiResponse::KEY_SPEDITIONS][$spedCode];
            $this->assertEquals($i[ApiResponse::KEY_CODE], $spedition->getCode());
//            $this->assertEquals($i[ ApiResponse::KEY_LABEL ], $spedition->getLabel());

            // TODO: check translations
        }
    }

} // end of class
