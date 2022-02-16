<?php

namespace OlzaLogistic\PpApi\Client\Tests\Traits;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\ApiResponse;

trait GeneratorsTrait
{
    /**
     * Generates random string, with optional prefix
     *
     * @param string|null $prefix    Optional prefix to be added to generated string.
     * @param int         $length    Length of the string to be generated.
     * @param string|null $separator Optional prefix separator.
     *
     * @return string
     */
    protected function getRandomString(string $prefix = null, int $length = 24,
                                       string $separator = '_'): string
    {
        if ($length < 1) {
            throw new \RuntimeException('Length must be greater than 0');
        }

        $prefix = ($prefix !== null) ? "{$prefix}{$separator}" : '';

        return \substr($prefix . \md5(\uniqid('', true)), 0, $length);
    }

    /**
     * Generates random integer value from withing specified range.
     *
     * @param int $min Min allowed value (inclusive)
     * @param int $max Max allowed value (inclusive)
     *
     * @return int
     *
     * @throws \Exception
     */
    protected function getRandomInt(int $min = 0, int $max = 100): int
    {
        return \random_int($min, $max);
    }

    /**
     * Generate Random float value
     *
     * @param float $min   Minimal value
     * @param float $max   Maximal value
     * @param int   $round The optional number of decimal digits to round to.
     *                     Default 0 means not rounding.
     */
    function getRandomFloat(float $min, float $max, int $round = 0)
    {
        $result = $min + \mt_rand() / \mt_getrandmax() * ($max - $min);
        if ($round > 0) {
            $result = \round($result, $round);
        }

        return $result;
    }

} // end of trait
