<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Util;

/**
 * JSON related helper methods
 */
final class Json
{
    /**
     * decodes JSON string with JSON_THROW_ON_ERROR flag
     *
     * @param string $json JSON string to decode
     *
     * @return array Decoded JSON data
     *
     * @throws \JsonException on JSON decoding error
     */
    public static function decode(string $json): array
    {
        /** @var array $result */
        $result = \json_decode($json, true, 32, \JSON_THROW_ON_ERROR);

        return $result;
    }

    /**
     * encodes data with JSON_THROW_ON_ERROR flag
     *
     * @param array $data Data to encode
     *
     * @return string JSON encoded data
     *
     * @throws \JsonException on JSON encoding error
     */
    public static function encode(array $data): string
    {
        return \json_encode($data, \JSON_THROW_ON_ERROR);
    }

}
