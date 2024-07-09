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
     * Helper methods that imitates JSON_THROW_ON_ERROR flag on PHP < 7.3
     *
     * @param string $json JSON string to decode
     *
     * @return array Decoded JSON data
     *
     * @throws \JsonException on JSON decoding error
     */
    public static function decode(string $json): array
    {
        $flags = 0;
        if (version_compare(phpversion(), '7.3.0', '>=')) {
            $flags |= \JSON_THROW_ON_ERROR;
        }

        $decodedJson = \json_decode($json, true, 32, $flags);
        if (\json_last_error() !== \JSON_ERROR_NONE) {
            throw new \JsonException('JSON decoding error: ' . \json_last_error_msg());
        }

        /** @var array $decodedJson */
        return $decodedJson;
    }

    /**
     * Helper methods that imitates JSON_THROW_ON_ERROR flag on PHP < 7.3
     *
     * @param array $data Data to encode
     *
     * @return string JSON encoded data
     *
     * @throws \JsonException on JSON encoding error
     */
    public static function encode(array $data): string
    {
        $flags = 0;
        if (version_compare(phpversion(), '7.3.0', '>=')) {
            $flags |= \JSON_THROW_ON_ERROR;
        }

        $json = \json_encode($data, $flags);
        if (\json_last_error() !== \JSON_ERROR_NONE) {
            throw new \JsonException('JSON encoding error: ' . \json_last_error_msg());
        }

        return $json;
    }

}
