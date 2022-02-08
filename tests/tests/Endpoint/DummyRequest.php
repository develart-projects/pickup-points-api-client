<?php

namespace OlzaLogistic\PpApi\Client\Tests\Endpoint;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class DummyRequest implements RequestInterface
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

    public function getRequestTarget()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withRequestTarget($requestTarget)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getMethod()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withMethod($method)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getUri()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }
} // end of class
