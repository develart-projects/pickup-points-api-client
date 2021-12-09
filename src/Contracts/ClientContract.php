<?php

namespace OlzaLogistic\PpApi\Client\Contracts;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2021 DevelArt IV
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use Develart\PpApi\Client\Result;

interface ClientContract
{
    /**
     * Returns all pickup points associated with given country and spedition(s).
     *
     * @param string      $countryCode Country to get data for (i.e. `cz`, `hu`...)
     * @param string|null $spedition   Optional code for specified carrier (spedition), i.e. `HUP-CS`).
     * @param string|null $city        Optional city name to get data for. Note: partial match is used.
     */
    public function find(string  $countryCode, ?string $spedition = null,
                         ?string $city = null): Result;

    /**
     * Return details about specified pickup points.
     *
     * @param string      $countryCode Country to get data for (i.e. `cz`, `hu`...)
     * @param string|null $spedition   Code for specified carrier (spedition), i.e. `HUP-CS`).
     * @param string      $id          Carrier's assigned pickup point code
     *
     * @return \Develart\PpApi\Client\Result
     */
    public function details(string $countryCode, string $spedition, string $id): Result;

} // end of class
