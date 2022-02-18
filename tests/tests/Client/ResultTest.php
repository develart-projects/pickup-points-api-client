<?php

namespace OlzaLogistic\PpApi\Client\Tests\Model;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\ApiResponse;
use OlzaLogistic\PpApi\Client\Result;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class ResultTest extends BaseTestCase
{

    /**
     * Ensures isApiResponseArrayValid() correctly validates received API data structure.
     *
     * @dataProvider isApiResponseValidDataProvider
     */
    public function testIsApiResponseValid(array $data): void
    {
//        var_dump($data);
        $expected = $data['expected'];
        $json = $data['json'];
        $extraDataKeys = $data['extraKeys'] ?? null;

        $result = Result::asSuccess();

        /** @var bool $result */
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


} // end of class
