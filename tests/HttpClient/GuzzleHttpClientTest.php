<?php

namespace OlzaLogistic\PpApi\Client\Tests\HttpClient;

use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Client;
use OlzaLogistic\PpApi\Client\Data;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

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
class GuzzleHttpClientTest extends BaseTestCase
{
    /**
     * Tests integration with Guzzle HTTP client
     */

    public function testGuzzle(): void
    {
        $url = 'http://127.0.0.1:8000';
        $accessToken = 'pass';

        $apiClient = Client::useApi($url)
            ->withAccessToken($accessToken)
            ->withGuzzleHttpClient()
            ->build();

        $filter = Params::create()
            ->withCountry('cz');
        $response = $apiClient->find($filter);

        $this->assertTrue($response->success());
        $this->assertInstanceOf(Data::class, $response->getData());
    }

} // end of class
