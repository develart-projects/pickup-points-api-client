<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client;

/**
 * Represents the HTTP methods that can be used in the API client.
 * It includes GET, POST, PUT, DELETE, and PATCH methods.
 */
class Method
{
    /** Represents the HTTP GET method. */
    const GET = 'GET';

    /** Represents the HTTP POST method. */
    const POST = 'POST';

    /** Represents the HTTP PUT method. */
    const PUT = 'PUT';

    /** Represents the HTTP DELETE method. */
    const DELETE = 'DELETE';

    /** Represents the HTTP PATCH method. */
    const PATCH = 'PATCH';
}
