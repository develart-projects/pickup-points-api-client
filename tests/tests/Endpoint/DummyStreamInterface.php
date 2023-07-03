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

use Psr\Http\Message\StreamInterface;

class DummyStreamInterface implements StreamInterface
{
    public function __toString(): string
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function close(): void
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function detach()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getSize(): ?int
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function tell(): int
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function eof(): bool
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function isSeekable(): bool
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function seek($offset, $whence = SEEK_SET): void
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function rewind(): void
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function isWritable(): bool
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function write($string): int
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function isReadable(): bool
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function read($length): string
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getContents(): string
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
    }
} // end of class
