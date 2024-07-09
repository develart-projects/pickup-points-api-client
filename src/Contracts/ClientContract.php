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

namespace OlzaLogistic\PpApi\Client\Contracts;

use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Result;

interface ClientContract
{
    /**
     * Returns all pickup points associated with given country and spedition(s).
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     */
    public function find(Params $apiParams): Result;

    /**
     * Returns details about given Pickup Point.
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     */
    public function details(Params $apiParams): Result;

    /**
     * Returns list of nearby Pickup Points matching search criteria.
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     */
    public function nearby(Params $apiParams): Result;

    /**
     * Returns list current API runtime params and available options.
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     */
    public function config(Params $apiParams): Result;

    public function rawRequest(string $httpMethod, string $endpoint, Params $apiParams): Result;

} // end of class
