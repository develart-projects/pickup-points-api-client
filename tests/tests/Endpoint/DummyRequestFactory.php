<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Endpoint;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

class DummyRequestFactory implements RequestFactoryInterface
{
    public function createRequest(string $method, $uri): RequestInterface
    {
//        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
        return new DummyRequest();
    }

} // end of class
