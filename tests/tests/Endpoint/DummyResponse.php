<?php

namespace OlzaLogistic\PpApi\Client\Tests\Endpoint;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class DummyResponse implements ResponseInterface
{
    public function getProtocolVersion()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withProtocolVersion($version)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getHeaders()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function hasHeader($name)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getHeader($name)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getHeaderLine($name)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withHeader($name, $value)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withAddedHeader($name, $value)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withoutHeader($name)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getBody()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withBody(StreamInterface $body)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getStatusCode()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getReasonPhrase()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

} // end of class
