<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2023-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client;

/**
 * PP Api response codes.
 *
 * Based on src/Consts/ApiCode.php
 */
class ApiCode
{

    /**
     * Requested data was not found (i.e. invalid PP reference ID, or invalid carrier ID etc.).
     *
     * @var int
     */
    public const ERROR_OBJECT_NOT_FOUND = 100;

    /**
     * API rejects the request due to invalid credentials (like invalid or outdated access token)
     *
     * @var int
     */
    public const ERROR_ACCESS_DENIED = 101;

}
