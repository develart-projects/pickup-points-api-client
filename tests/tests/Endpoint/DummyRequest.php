<?php

/**
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Endpoint;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class DummyRequest implements RequestInterface
{
    public function getProtocolVersion(): string
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withProtocolVersion($version): MessageInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getHeaders(): array
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function hasHeader($name): bool
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getHeader($name): array
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getHeaderLine($name): string
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withHeader($name, $value): MessageInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withAddedHeader($name, $value): MessageInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withoutHeader($name): MessageInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getBody(): StreamInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withBody(StreamInterface $body): MessageInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getRequestTarget(): string
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withRequestTarget($requestTarget): RequestInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getMethod(): string
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withMethod($method): RequestInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getUri(): UriInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function withUri(UriInterface $uri, $preserveHost = false): RequestInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }
} // end of class
