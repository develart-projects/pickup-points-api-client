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

use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Result;

interface ClientContract
{
    /**
     * Returns all pickup points associated with given country and spedition(s).
     */
    public function find(Params $apiParams): Result;

    /**
     * Return details about specified pickup points.
     */
    public function details(Params $apiParams): Result;

} // end of class
