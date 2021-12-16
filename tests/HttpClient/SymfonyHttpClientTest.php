<?php

namespace OlzaLogistic\PpApi\Client\Tests\HttpClient;

use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Client;
use OlzaLogistic\PpApi\Client\Data;
use OlzaLogistic\PpApi\Client\FieldType;
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
class SymfonyHttpClientTest extends BaseTestCase
{
    /**
     * Tests integration with Symfony HTTP client
     */
    public function testSymfonyHttpClient(): void
    {
        $url = 'http://127.0.0.1:8000';
        $accessToken = 'pass';

        $apiClient = Client::useApi($url)
            ->withAccessToken($accessToken)
            ->withSymfonyHttpClient()
            ->get();

        $filter = (new Params())
            ->withCountry('cz')
            ->addField(FieldType::ADDRESS)
            ->addField(FieldType::LOCATION);

        $response = $apiClient->find($filter);

        $this->assertTrue($response->success());
        $this->assertInstanceOf(Data::class, $response->getData());
    }

} // end of class
