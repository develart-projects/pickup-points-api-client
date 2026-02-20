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

use OlzaLogistic\PpApi\Client\Client;
use OlzaLogistic\PpApi\Client\Exception\ClientNotSealedException;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use OlzaLogistic\PpApi\Client\Tests\Util\Lockpick;
use OlzaLogistic\PpApi\Client\Tests\Endpoint\DummyStreamFactory;
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

    /* ****************************************************************************************** */

    public function testWithStreamFactoryStoresInstance(): void
    {
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');
        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $httpClientStub = $this->createStub(DummyHttpClient::class);
        $streamFactoryStub = $this->createStub(DummyStreamFactory::class);

        $apiClient = Client::useApi($url)
                           ->withAccessToken($accessToken)
                           ->withHttpClient($httpClientStub)
                           ->withRequestFactory($requestFactoryStub)
                           ->withStreamFactory($streamFactoryStub)
                           ->build();

        $actual = Lockpick::call($apiClient, 'getStreamFactory');
        Assert::assertSame($streamFactoryStub, $actual);
    }

    public function testWithStreamFactoryThrowsWhenAlreadyInitialized(): void
    {
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');
        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $httpClientStub = $this->createStub(DummyHttpClient::class);
        $streamFactoryStub = $this->createStub(DummyStreamFactory::class);

        $apiClient = Client::useApi($url)
                           ->withAccessToken($accessToken)
                           ->withHttpClient($httpClientStub)
                           ->withRequestFactory($requestFactoryStub)
                           ->build();

        $this->expectException(\OlzaLogistic\PpApi\Client\Exception\ClientAlreadyInitializedException::class);
        $apiClient->withStreamFactory($streamFactoryStub);
    }

    /* ****************************************************************************************** */

    public function testFindThrowsWhenClientNotSealed(): void
    {
        // calling endpoint method without build() must throw ClientNotSealedException
        $url = $this->getRandomString('url');
        $accessToken = $this->getRandomString('pass');
        $requestFactoryStub = $this->createStub(DummyRequestFactory::class);
        $httpClientStub = $this->createStub(DummyHttpClient::class);

        $this->expectException(ClientNotSealedException::class);
        Client::useApi($url)
              ->withAccessToken($accessToken)
              ->withHttpClient($httpClientStub)
              ->withRequestFactory($requestFactoryStub)
              ->find(Params::create());
    }

} // end of class
