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
    public function find(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();

        $apiParams->setRequiredFields([
            Params::COUNTRY,
            Params::SPEDITION,
        ]);
        return $this->handleHttpRequest(Method::GET, Route::FIND, $apiParams,
            static function (ResponseInterface $apiResponse) {
                return Result::fromApiResponseWithItems($apiResponse);
            }
        );
    }


    public function details(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();

        $apiParams->setRequiredFields([
            Params::COUNTRY,
            Params::SPEDITION,
            Params::ID,
        ]);
        return $this->handleHttpRequest(Method::GET, Route::DETAILS, $apiParams,
            static function (ResponseInterface $apiResponse) {
                return Result::fromApiResponseWithItems($apiResponse);
            }
        );
    }

    public function nearby(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();
        $apiParams->setRequiredFields([
            Params::COUNTRY,
            Params::LOCATION,
        ]);
        return $this->handleHttpRequest(Method::GET, Route::NEARBY, $apiParams,
            static function (ResponseInterface $apiResponse) {
                return Result::fromApiResponseWithItems($apiResponse);
            }
        );
    }

    public function config(Params $apiParams): Result
    {
        $this->assertConfigurationSealed();

        $apiParams->setRequiredFields([
            Params::COUNTRY,
        ]);
        return $this->handleHttpRequest(Method::GET, Route::CONFIG, $apiParams,
            static function (ResponseInterface $apiResponse) {
                return Result::fromConfigApiResponse($apiResponse);
            }
        );
    }

    public function rawRequest(string $httpMethod,
                               string $endpoint,
                               ?Params $apiParams = null): Result
    {
        $this->assertConfigurationSealed();

        if ($apiParams === null) {
            $apiParams = Params::create();
        }

        return $this->handleHttpRequest($httpMethod, $endpoint, $apiParams,
            static function (ResponseInterface $apiResponse) {
                return Result::fromGenericApiResponse($apiResponse);
            }
        );
    }

} // end of class
