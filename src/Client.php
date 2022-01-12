<?php

namespace OlzaLogistic\PpApi\Client;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2021-2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\Consts\Route;
use OlzaLogistic\PpApi\Client\ApiParam;

class Client extends ClientBase
{
    /**
     * Talks to API and returns list of PPs matching search criteria.
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     *
     * @return Result
     */
    public function find(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();

        $requiredFields = [
            Params::COUNTRY,
        ];
        $apiParams->setRequiredFields($requiredFields);
        return $this->handleHttpRequest(Route::FIND, $apiParams);
    }

    /**
     * Return details about given PP
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     *
     * @return Result
     */
    public function details(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();

        $requiredFields = [
            Params::COUNTRY,
            Params::SPEDITION,
            Params::ID,
        ];
        $apiParams->setRequiredFields($requiredFields);
        return $this->handleHttpRequest(Route::DETAILS, $apiParams);
    }

    /**
     * Talks to API and returns list of nearby PPs matching search criteria.
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     *
     * @return Result
     */
    public function nearby(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();
        $requiredFields = [
            Params::COUNTRY,
            Params::LOCATION,
        ];
        $apiParams->setRequiredFields($requiredFields);
        return $this->handleHttpRequest(Route::NEARBY, $apiParams);
    }
} // end of class
