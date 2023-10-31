<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
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

} // end of class
