<?php

namespace OlzaLogistic\PpApi\Client;

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
class Client extends ClientBase
{
    /**
     * Talks to API and returns list of PPs matching search criteria.
     *
     * @param string      $countryCode Mandatory country code (i.e. 'cz', 'hu', etc.).
     * @param string|null $spedition   (optional) Olza's spedition code (i.e. 'CP-BAL', etc.).
     * @param string|null $city        (optional) City name to narrow the search to.
     *
     * @return \OlzaLogistic\PpApi\Client\Result
     */
    public function find(string  $countryCode, ?string $spedition = null,
                         ?string $city = null): Result
    {
        $this->assertConfigurationSealed();

        $queryArgs = [
            Consts::PARAM_COUNTRY => $countryCode,
        ];
        if (!empty($spedition)) {
            $queryArgs[ Consts::PARAM_SPEDITION ] = $spedition;
        }
        if (!empty($city)) {
            $queryArgs[ Consts::PARAM_CITY ] = $city;
        }

        return $this->handleHttpRequest('/pp/find', $queryArgs);
    }

    /**
     * Return details about given PP
     *
     * @param string $countryCode Mandatory country code (i.e. 'cz', 'hu', etc.).
     * @param string $spedition   Olza's spedition code (i.e. 'CP-BAL', etc.).
     * @param string $id          Pickup Point ID
     *
     * TODO: add support for fields
     *
     * @return \OlzaLogistic\PpApi\Client\Result
     */
    public function details(string $countryCode, string $spedition, string $id): Result
    {
        $this->assertConfigurationSealed();

        $queryArgs = [
            Consts::PARAM_COUNTRY   => $countryCode,
            Consts::PARAM_SPEDITION => $spedition,
            Consts::PARAM_ID        => $id,
        ];
        return $this->handleHttpRequest('/pp/details', $queryArgs);
    }

} // end of class
