<?php

namespace OlzaLogistic\PpApi\Client\Tests\Endpoint;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2021-2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\ApiResponse;
use OlzaLogistic\PpApi\Client\Client;
use OlzaLogistic\PpApi\Client\Country;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class ConfigTest extends BaseTestCase
{
    protected const apiJsonConfigResponse = <<<JSON
            {
              "success": true,
              "code": 0,
              "message": "OK",
              "data": {
                "config": {
                  "cache.pp.ttl": 3600
                },
                "speditions": {
                  "cp-bal": {
                    "code": "cp-bal",
                    "label": "cp-bal",
                    "names": {
                      "cs": "Czech Post (cs)",
                      "en": "Czech Post (en)",
                      "de": "Czech Post (de)",
                      "hu": "Czech Post (hu)",
                      "pl": "Czech Post (pl)",
                      "sk": "Czech Post (sk)"
                    }
                  },
                  "gls-ps": {
                    "code": "gls-ps",
                    "label": "gls-ps",
                    "names": {
                      "cs": "GLS (cs)",
                      "en": "GLS (en)",
                      "de": "GLS (de)",
                      "hu": "GLS (hu)",
                      "pl": "GLS (pl)",
                      "sk": "GLS (sk)"
                    }
                  },
                  "zas": {
                    "code": "zas",
                    "label": "zas",
                    "names": {
                      "cs": "Packeta (IPP) (cs)",
                      "en": "Packeta (IPP) (en)",
                      "de": "Packeta (IPP) (de)",
                      "hu": "Packeta (IPP) (hu)",
                      "pl": "Packeta (IPP) (pl)",
                      "sk": "Packeta (IPP) (sk)"
                    }
                  },
                  "ppl-ps": {
                    "code": "ppl-ps",
                    "label": "ppl-ps",
                    "names": {
                      "cs": "PPL (cs)",
                      "en": "PPL (en)",
                      "de": "PPL (de)",
                      "hu": "PPL (hu)",
                      "pl": "PPL (pl)",
                      "sk": "PPL (sk)"
                    }
                  },
                  "bmcg-int-pp": {
                    "code": "bmcg-int-pp",
                    "label": "bmcg-int-pp",
                    "names": {
                      "cs": "We-Do (cs)",
                      "en": "We-Do (en)",
                      "de": "We-Do (de)",
                      "hu": "We-Do (hu)",
                      "pl": "We-Do (pl)",
                      "sk": "We-Do (sk)"
                    }
                  }
                }
              }
            }
        JSON;

    /**
     * Tests integration with Guzzle HTTP client
     */
    public function testConfig(): void
    {
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');


        $json = \json_decode(static::apiJsonConfigResponse, true, 32, JSON_THROW_ON_ERROR);
        $this->assertSuccessResponse($json);
        $jsonData = $json[ ApiResponse::KEY_DATA ];
        $this->assertNotNull($jsonData);

        $streamIfaceStub = $this->createStub(DummyStreamInterface::class);
        $streamIfaceStub->method('getContents')->willReturn(static::apiJsonConfigResponse);

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
            ->withPsrClient($httpClientStub, $requestFactoryStub)
            ->build();

        $apiParams = Params::create()->withCountry(Country::CZECH);

        // Call the method
        $result = $apiClient->config($apiParams);
        /** @var \OlzaLogistic\PpApi\Client\ConfigData $configData */
        $configData = $result->getData();

        $configItems = $configData->getConfigItems();
        $this->assertNotEmpty($configItems);
        $this->assertArrayEquals($configItems, $json[ ApiResponse::KEY_DATA ][ ApiResponse::KEY_CONFIG ]);

        $speditions = $configData->getSpeditions();
        $this->assertNotEmpty($speditions);

        $returnedSpeditionCodes = \array_keys($speditions);
        $this->assertArrayEquals(\array_keys($jsonData[ ApiResponse::KEY_SPEDITIONS ]), $returnedSpeditionCodes);

        foreach ($speditions as $spedCode => $spedition) {
            /** @var \OlzaLogistic\PpApi\Client\Model\Spedition $spedition */

            $i = $jsonData[ ApiResponse::KEY_SPEDITIONS ][ $spedCode ];
            $this->assertEquals($i[ ApiResponse::KEY_CODE ], $spedition->getCode());
            $this->assertEquals($i[ ApiResponse::KEY_LABEL ], $spedition->getLabel());

            // TODO: check translations
        }
    }

} // end of class
