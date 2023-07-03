<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Traits;

use OlzaLogistic\PpApi\Client\ApiResponse;

trait TestHelpersTrait
{
    use GeneratorsTrait;

    /* ****************************************************************************************** */

    /**
     * Ensures instsance of Response Builder holds successful response.
     *
     * @param array $json    Final JSON response array.
     * @param int   $apiCode API code to check.
     *
     * @return void
     */
    protected function assertSuccessResponse(array $json, int $apiCode = 0): void
    {
        $this->assertTrue($json[ ApiResponse::KEY_SUCCESS ]);
        $this->assertEquals($apiCode, $json[ ApiResponse::KEY_CODE ]);
        $this->assertNotEmpty($json[ ApiResponse::KEY_MESSAGE ]);
    }

    /**
     * Ensures instsance of Response Builder holds error response.
     *
     * @param array $json    Final JSON response array.
     * @param int   $apiCode Expected API code
     *
     * @return void
     */
    protected function assertErrorResponse(array $json, int $apiCode): void
    {
        $this->assertFalse($json[ ApiResponse::KEY_SUCCESS ]);
        $this->assertEquals($apiCode, $json[ ApiResponse::KEY_CODE ]);
        $this->assertNotEmpty($json[ ApiResponse::KEY_MESSAGE ]);
        $this->assertNull($json[ ApiResponse::KEY_DATA ]);
    }

    /**
     * Validates if given $json contains all elements expected in valid JSON response.
     *
     * @param array $json API response to validate.
     */
    public function assertValidJsonResponse(array $json): void
    {
        $this->assertIsArray($json);
        $this->assertIsBool($json[ ApiResponse::KEY_SUCCESS ]);
        $this->assertIsInt($json[ ApiResponse::KEY_CODE ]);
        $this->assertIsString($json[ ApiResponse::KEY_MESSAGE ]);
        $responsePayload = $json[ ApiResponse::KEY_DATA ];
        $this->assertTrue(($responsePayload === null) || \is_array($responsePayload),
            "Response 'data' must be either object or null");
    }

} // end of class
