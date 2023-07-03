<?php

/**
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\HttpClient;

use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Client;
use OlzaLogistic\PpApi\Client\Model\Country;
use OlzaLogistic\PpApi\Client\Data;
use OlzaLogistic\PpApi\Client\FieldType;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class GuzzleHttpClientTest extends BaseTestCase
{
    /**
     * Tests integration with Guzzle HTTP client
     */
    public function testGuzzle(): void
    {
        $this->markTestSkipped('Not isolated.');

//        $url = 'http://127.0.0.1:8000';
//        $accessToken = 'pass';
//
//        $apiClient = Client::useApi($url)
//            ->withAccessToken($accessToken)
//            ->withGuzzleHttpClient()
//            ->build();
//
//        $sped = $this->getRandomString('sped');
//        $filter = Params::create()
//            ->withCountry(Country::CZECH)
//            ->withSpedition($sped);
//        $response = $apiClient->find($filter);
//
//        $this->assertTrue($response->success(), $response->getMessage());
//        $this->assertInstanceOf(Data::class, $response->getData(), $response->getMessage());
    }

} // end of class
