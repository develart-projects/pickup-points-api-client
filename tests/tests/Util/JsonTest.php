<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Util;

use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use OlzaLogistic\PpApi\Client\Util\Json;
use PHPUnit\Framework\Assert;

class JsonTest extends BaseTestCase
{
    public function testDecode(): void
    {
        $expected = [
            $this->getRandomString('k1') => $this->getRandomInt(),
            $this->getRandomString('k2') => null,
            $this->getRandomString('k3') => $this->getRandomString(),
        ];

        /** @var string $encoded */
        $encoded = \json_encode($expected);
        Assert::assertNotFalse($encoded);
        $actual = Json::decode($encoded);
        Assert::assertEquals($expected, $actual);
    }

    /**
     * NOTE: it's important to ensure this test runs on pre-PHP 7.3 as well.
     */
    public function testInvalidDecode(): void
    {
        $str = '{{invald json';
        $this->expectException(\JsonException::class);
        Json::decode($str);
    }

    /* ****************************************************************************************** */

    /**
     * Tests successful encoding of an array to JSON.
     */
    public function testEncode(): void
    {
        $data = [
            $this->getRandomString('k1') => $this->getRandomInt(),
            $this->getRandomString('k2') => null,
            $this->getRandomString('k3') => $this->getRandomString(),
        ];

        $encoded = Json::encode($data);
        Assert::assertIsString($encoded);
        Assert::assertEquals($data, \json_decode($encoded, true));
    }

    /**
     * Tests encoding of various data types.
     */
    public function testEncodeVariousTypes(): void
    {
        $data = [
            'integer' => $this->getRandomInt(),
            'string'  => $this->getRandomString(),
            'null'    => null,
            'boolean' => $this->getRandomBool(),
            'float'   => $this->getRandomFloat(0, 100),
            'array'   => [1, 2, 3],
            'nested'  => [
                $this->getRandomString() => $this->getRandomString(),
                $this->getRandomString() => [
                    $this->getRandomString() => $this->getRandomString(),
                ],
            ],
        ];

        $encoded = Json::encode($data);
        Assert::assertIsString($encoded);
        Assert::assertEquals($data, \json_decode($encoded, true));
    }

    /**
     * Tests encoding of a large array to ensure it doesn't hit memory limits.
     */
    public function testEncodeLargeArray(): void
    {
        $data = [];
        for ($i = 0; $i < 10000; $i++) {
            $data[$this->getRandomString("key_{$i}")] = $this->getRandomString("value_{$i}");
        }

        $encoded = Json::encode($data);
        Assert::assertIsString($encoded);
        Assert::assertEquals($data, \json_decode($encoded, true));
    }

    /**
     * Tests encoding of invalid UTF-8 strings.
     */
    public function testEncodeInvalidUtf8(): void
    {
        $invalidUtf8 = "\xB1\x31";
        $data = ['invalid' => $invalidUtf8];

        $this->expectException(\JsonException::class);
        Json::encode($data);
    }

} // end of class
