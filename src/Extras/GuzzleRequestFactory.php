<?php
declare(strict_types=1);

namespace OlzaLogistic\PpApi\Client\Extras;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

/**
 * PSR-17 compatible request factory for Guzzle HTTP client.
 *
 * NOTE: requires Guzzle to be installed as project dependency
 */
class GuzzleRequestFactory implements RequestFactoryInterface
{
    public function createRequest(string $method, $uri): RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request($method, $uri);
    }
}
