<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Client;

use OlzaLogistic\PpApi\Client\ApiResponse;
use OlzaLogistic\PpApi\Client\Result;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use PHPUnit\Framework\Assert;
use \Psr\Http\Message\StreamInterface;
use \Psr\Http\Message\ResponseInterface;

class ResultTest extends BaseTestCase
{

    /**
     * Ensures isApiResponseArrayValid() correctly validates received API data structure.
     *
     * @dataProvider isApiResponseValidDataProvider
     */
    public function testIsApiResponseValid(array $data): void
    {
        $expected = $data['expected'];
        $json = $data['json'];
        $extraDataKeys = $data['extraKeys'] ?? null;

        $result = Result::asSuccess();

        $args = [
            $json,
            $extraDataKeys,
        ];
        $result = $this->callProtectedMethod($result, 'isApiResponseArrayValid', $args);

        $this->assertEquals($expected, $result);
    }

    /**
     * Feeds data to testIsApiResponseValid() test
     */
    public function isApiResponseValidDataProvider(): array
    {
        $result = [];

        /* -------------------------------------------------------------------------------------- */

        $set = [
            'expected' => true,
            'json'     => [
                ApiResponse::KEY_SUCCESS => $this->getRandomBool(),
                ApiResponse::KEY_MESSAGE => $this->getRandomString(),
                ApiResponse::KEY_CODE    => $this->getRandomInt(0, 255),
                ApiResponse::KEY_DATA    => null,
            ],
        ];
        $result[] = [$set];

        /* -------------------------------------------------------------------------------------- */

        // Missing fields
        $set = [
            'expected' => false,
            'json'     => [
                ApiResponse::KEY_MESSAGE => $this->getRandomString(),
                ApiResponse::KEY_CODE    => $this->getRandomInt(0, 255),
                ApiResponse::KEY_DATA    => null,
            ],
        ];
        $result[] = [$set];

        $set = [
            'expected' => false,
            'json'     => [
                ApiResponse::KEY_SUCCESS => true,
                ApiResponse::KEY_CODE    => $this->getRandomInt(0, 255),
                ApiResponse::KEY_DATA    => null,
            ],
        ];
        $result[] = [$set];

        $set = [
            'expected' => false,
            'json'     => [
                ApiResponse::KEY_SUCCESS => true,
                ApiResponse::KEY_MESSAGE => $this->getRandomString(),
                ApiResponse::KEY_DATA    => null,
            ],
        ];
        $result[] = [$set];

        $set = [
            'expected' => false,
            'json'     => [
                ApiResponse::KEY_SUCCESS => true,
                ApiResponse::KEY_MESSAGE => $this->getRandomString(),
                ApiResponse::KEY_CODE    => $this->getRandomInt(0, 255),
            ],
        ];
        $result[] = [$set];

        /* -------------------------------------------------------------------------------------- */

        return $result;
    }

    /* ****************************************************************************************** */

    public function testArrayableSuccess(): void
    {
        $message = $this->getRandomString('msg');

        $expected = [
            'success' => true,
            'code'    => 0,
            'message' => $message,
            'data'    => null,
        ];

        $result = Result::asSuccess();
        $this->call($result, 'setMessage', [$message]);
        $actual = $result->toArray();

        Assert::assertEquals($expected, $actual);
    }

    public function testArrayableError(): void
    {
        $message = $this->getRandomString('msg');
        $code = $this->getRandomInt(1, 255);

        $expected = [
            'success' => false,
            'code'    => $code,
            'message' => $message,
            'data'    => null,
        ];

        $result = Result::asError();
        $this->call($result, 'setMessage', [$message]);
        $this->call($result, 'setCode', [$code]);
        $actual = $result->toArray();

        Assert::assertEquals($expected, $actual);
    }

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    public static function call(object $obj, string $methodName, array $args = [])
    {
        $reflection = new \ReflectionClass($obj);
        $method = $reflection->getMethod($methodName);
        
        if (PHP_VERSION_ID < 80100) { // only for PHP < 8.1
            // NOTE: In PHP 8.1+ setAccessible() is deprecated and not needed for non-private methods,
            // but in older versions it is needed to call protected/private methods
            $method->setAccessible(true);
        }

        return $method->invokeArgs($obj, $args);
    }

    /* ****************************************************************************************** */

    public function testAsSuccessWithoutData(): void
    {
        $result = Result::asSuccess();
        
        $this->assertTrue($result->success());
        $this->assertNull($result->getData());
    }

    public function testAsSuccessWithData(): void
    {
        $data = new \OlzaLogistic\PpApi\Client\Data();
        $key = $this->getRandomString('key');
        $value = $this->getRandomString('value');
        $data[$key] = $value;
        
        $result = Result::asSuccess($data);
        
        $this->assertTrue($result->success());
        $this->assertNotNull($result->getData());
        $this->assertInstanceOf(\OlzaLogistic\PpApi\Client\Data::class, $result->getData());
    }

    public function testAsError(): void
    {
        $result = Result::asError();
        
        $this->assertFalse($result->success());
        $this->assertNull($result->getData());
    }

    public function testFromThrowable(): void
    {
        $message = $this->getRandomString('error_message');
        $code = $this->getRandomInt(1, 999);
        $exception = new \Exception($message, $code);
        
        $result = Result::fromThrowable($exception);
        
        $this->assertFalse($result->success());
        $this->assertEquals($code, $result->getCode());
        $this->assertEquals($message, $result->getMessage());
    }

    public function testGetCodeReturnsZeroByDefault(): void
    {
        $result = Result::asSuccess();
        
        $this->assertEquals(0, $result->getCode());
    }

    public function testGetMessage(): void
    {
        $message = $this->getRandomString('test_message');
        $result = Result::asSuccess();
        $this->call($result, 'setMessage', [$message]);
        
        $this->assertEquals($message, $result->getMessage());
    }

    public function testGetMessageReturnsEmptyStringByDefault(): void
    {
        $result = Result::asSuccess();
        
        $this->assertEquals('', $result->getMessage());
    }

    public function testGetData(): void
    {
        $data = new \OlzaLogistic\PpApi\Client\Data();
        $result = Result::asSuccess();
        $this->call($result, 'setData', [$data]);
        
        $this->assertInstanceOf(\OlzaLogistic\PpApi\Client\Data::class, $result->getData());
    }

    public function testGetDataReturnsNullByDefault(): void
    {
        $result = Result::asSuccess();
        
        $this->assertNull($result->getData());
    }

    public function testToArrayWithData(): void
    {
        $data = new \OlzaLogistic\PpApi\Client\Data();
        $key = $this->getRandomString('key');
        $value = $this->getRandomString('value');
        $data[$key] = $value;
        
        $message = $this->getRandomString('message');
        $code = $this->getRandomInt(0, 100);
        
        $result = Result::asSuccess($data);
        $this->call($result, 'setMessage', [$message]);
        $this->call($result, 'setCode', [$code]);
        
        $array = $result->toArray();
        
        $this->assertIsArray($array);
        $this->assertArrayHasKey('success', $array);
        $this->assertArrayHasKey('code', $array);
        $this->assertArrayHasKey('message', $array);
        $this->assertArrayHasKey('data', $array);
        $this->assertTrue($array['success']);
        $this->assertEquals($code, $array['code']);
        $this->assertEquals($message, $array['message']);
        $this->assertIsArray($array['data']);
    }

    /* ****************************************************************************************** */

    public function testFromApiResponseWithItemsSuccessWithEmptyItems(): void
    {
        $apiJson = \json_encode([
            'success' => true,
            'code'    => 0,
            'message' => 'OK',
            'data'    => [
                'items' => [],
            ],
        ]);

        $streamStub = $this->createStub(StreamInterface::class);
        $streamStub->method('getContents')->willReturn($apiJson);

        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($streamStub);
        $responseMock->method('getStatusCode')->willReturn(200);

        $result = Result::fromApiResponseWithItems($responseMock);

        $this->assertTrue($result->success());
        $this->assertEquals(0, $result->getCode());
        $this->assertNotNull($result->getData());
    }

    public function testFromApiResponseWithItemsSuccessWithNullData(): void
    {
        // when success=false, data=null is valid (no extra keys checked)
        $apiJson = \json_encode([
            'success' => false,
            'code'    => 1,
            'message' => 'Error',
            'data'    => null,
        ]);

        $streamStub = $this->createStub(StreamInterface::class);
        $streamStub->method('getContents')->willReturn($apiJson);

        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($streamStub);
        $responseMock->method('getStatusCode')->willReturn(200);

        $result = Result::fromApiResponseWithItems($responseMock);

        $this->assertFalse($result->success());
        $this->assertNull($result->getData());
    }

    public function testFromApiResponseWithItemsHandlesInvalidJson(): void
    {
        $streamStub = $this->createStub(StreamInterface::class);
        $streamStub->method('getContents')->willReturn('invalid-json');

        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($streamStub);
        $responseMock->method('getStatusCode')->willReturn(200);

        $result = Result::fromApiResponseWithItems($responseMock);

        // invalid JSON must be caught and returned as error result
        $this->assertFalse($result->success());
    }

    /* ****************************************************************************************** */

    public function testFromGenericApiResponseSuccessWithNullData(): void
    {
        $apiJson = \json_encode([
            'success' => true,
            'code'    => 0,
            'message' => 'OK',
            'data'    => null,
        ]);

        $streamStub = $this->createStub(StreamInterface::class);
        $streamStub->method('getContents')->willReturn($apiJson);

        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($streamStub);
        $responseMock->method('getStatusCode')->willReturn(200);

        $result = Result::fromGenericApiResponse($responseMock);

        $this->assertTrue($result->success());
        $this->assertNull($result->getData());
    }

    public function testFromGenericApiResponseSuccessWithData(): void
    {
        $apiJson = \json_encode([
            'success' => true,
            'code'    => 0,
            'message' => 'OK',
            'data'    => ['key' => 'value'],
        ]);

        $streamStub = $this->createStub(StreamInterface::class);
        $streamStub->method('getContents')->willReturn($apiJson);

        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($streamStub);
        $responseMock->method('getStatusCode')->willReturn(200);

        $result = Result::fromGenericApiResponse($responseMock);

        $this->assertTrue($result->success());
        $this->assertNotNull($result->getData());
    }

    public function testFromGenericApiResponseHandlesInvalidJson(): void
    {
        $streamStub = $this->createStub(StreamInterface::class);
        $streamStub->method('getContents')->willReturn('not-valid-json!!');

        $responseMock = $this->createStub(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($streamStub);
        $responseMock->method('getStatusCode')->willReturn(200);

        $result = Result::fromGenericApiResponse($responseMock);

        // invalid JSON must be caught and returned as error result
        $this->assertFalse($result->success());
    }

} // end of class
