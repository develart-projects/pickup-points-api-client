<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Endpoint;

use OlzaLogistic\PpApi\Client\Client;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use OlzaLogistic\PpApi\Client\Tests\Util\Lockpick;
use PHPUnit\Framework\Assert;

class ClientTest extends BaseTestCase
{
    public function testUserAgentAccessors(): void
    {
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');
        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $httpClientStub = $this->createStub(DummyHttpClient::class);
        $userAgent = $this->getRandomString('ua');

        $apiClient = Client::useApi($url)
                           ->withAccessToken($accessToken)
                           ->withHttpClient($httpClientStub)
                           ->withRequestFactory($requestFactoryStub)
                           ->withUserAgent($userAgent)
                           ->build();

        $actual = Lockpick::call($apiClient, 'getUserAgent');
        Assert::assertEquals($userAgent, $actual);
    }

    public function testThrowOnErrorAccessors(): void
    {
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');
        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $httpClientStub = $this->createStub(DummyHttpClient::class);

        $apiClient = Client::useApi($url)
                           ->withAccessToken($accessToken)
                           ->withHttpClient($httpClientStub)
                           ->withRequestFactory($requestFactoryStub)
                           ->build();

        $actual = Lockpick::call($apiClient, 'getThrowOnError');
        Assert::assertFalse($actual);

        $apiClient = Client::useApi($url)
                           ->withAccessToken($accessToken)
                           ->withHttpClient($httpClientStub)
                           ->withRequestFactory($requestFactoryStub)
                           ->throwOnError()
                           ->build();

        $actual = Lockpick::call($apiClient, 'getThrowOnError');
        Assert::assertTrue($actual);
    }

    /* ****************************************************************************************** */

    /**
     * @dataProvider provideInvalidAccessTokens
     */
    public function testInvalidAccessToken(string $accessToken): void
    {
        $url = $this->getRandomString('url');
        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $httpClientStub = $this->createStub(DummyHttpClient::class);

        $this->expectException(\InvalidArgumentException::class);
        Client::useApi($url)
              ->withAccessToken($accessToken)
              ->withHttpClient($httpClientStub)
              ->withRequestFactory($requestFactoryStub)
              ->build();
    }

    public function provideInvalidAccessTokens(): array
    {
        return [
            [''],
            ['     '],
        ];
    }

    /* ****************************************************************************************** */

    /**
     * @dataProvider provideValidAccessTokens
     */
    public function testValidAccessToken(string $accessToken): void
    {
        $url = $this->getRandomString('url');
        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $httpClientStub = $this->createStub(DummyHttpClient::class);

        $apiClient = Client::useApi($url)
                           ->withAccessToken($accessToken)
                           ->withHttpClient($httpClientStub)
                           ->withRequestFactory($requestFactoryStub)
                           ->build();

        $actual = Lockpick::call($apiClient, 'getAccessToken');
        Assert::assertEquals($accessToken, $actual);
    }

    public function provideValidAccessTokens(): array
    {
        return [
            [$this->getRandomString('token')],
        ];
    }

} // end of class
