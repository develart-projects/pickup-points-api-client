<?php

namespace OlzaLogistic\PpApi\Client\Tests\HttpClient;

use OlzaLogistic\PpApi\Client\Client;
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
class GuzzleTest extends BaseTestCase
{
    public function testGuzzle(): void
    {
        $url = 'http://127.0.0.1:8000';
        $accessToken = 'pass';

        $apiClient = Client::useApi($url)
            ->withAccessToken($accessToken)
            ->withGuzzleClient()
            ->get();

        $response = $apiClient->find('cz');

        $this->assertTrue($response->success());
        $this->assertIsArray($response->getData());
    }

} // end of class
