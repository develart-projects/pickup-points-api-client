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

namespace OlzaLogistic\PpApi\Client;

use OlzaLogistic\PpApi\Client\Consts\Route;
use Psr\Http\Message\ResponseInterface;

/**
 * All exposed public methods of PP API client.
 */
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

        $apiParams->setRequiredFields([
            Params::COUNTRY,
            Params::SPEDITION,
        ]);
        return $this->handleHttpRequest(Route::FIND, $apiParams,
            static function (ResponseInterface $apiResponse) {
                return Result::fromApiResponseWithItems($apiResponse);
            }
        );
    }

    /**
     * Return details about given Pickup Point.
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     */
    public function details(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();

        $apiParams->setRequiredFields([
            Params::COUNTRY,
            Params::SPEDITION,
            Params::ID,
        ]);
        return $this->handleHttpRequest(Route::DETAILS, $apiParams,
            static function (ResponseInterface $apiResponse) {
                return Result::fromApiResponseWithItems($apiResponse);
            }
        );
    }

    /**
     * Talks to API and returns list of nearby Pickup Points matching search criteria.
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     */
    public function nearby(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();
        $apiParams->setRequiredFields([
            Params::COUNTRY,
            Params::LOCATION,
        ]);
        return $this->handleHttpRequest(Route::NEARBY, $apiParams,
            static function (ResponseInterface $apiResponse) {
                return Result::fromApiResponseWithItems($apiResponse);
            }
        );
    }

    /**
     * Talks to API and returns list current API runtime params and available options.
     *
     * @param Params $apiParams Populated instance of request parameters' container.
     */
    public function config(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();

        $apiParams->setRequiredFields([
            Params::COUNTRY,
        ]);
        return $this->handleHttpRequest(Route::CONFIG, $apiParams,
            static function (ResponseInterface $apiResponse) {
                return Result::fromConfigApiResponse($apiResponse);
            }
        );
    }

} // end of class
