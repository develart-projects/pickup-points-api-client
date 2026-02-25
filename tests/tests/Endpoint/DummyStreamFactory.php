<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Jozef Liška <jozef.liska (#) develart (.) cz>
 * @copyright 2026 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Endpoint;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class DummyStreamFactory implements StreamFactoryInterface
{
    public function createStream(string $content = ''): StreamInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        throw new \RuntimeException('Method not implemented: ' . __METHOD__);
    }

} // end of class
