<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Model;

use OlzaLogistic\PpApi\Client\ApiResponse;
use OlzaLogistic\PpApi\Client\Result;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use PHPUnit\Framework\Assert;

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
        $method->setAccessible(true);

        return $method->invokeArgs(\is_object($obj) ? $obj : null, $args);
    }

} // end of class
