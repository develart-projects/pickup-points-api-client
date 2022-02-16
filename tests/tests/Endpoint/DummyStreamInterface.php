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

    public function close()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function detach()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getSize()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function tell()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function eof()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function isSeekable()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    /**
     * @return int
     */
    public function rewind()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function isWritable()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function write($string)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function isReadable()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function read($length)
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getContents()
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
    }
} // end of class
