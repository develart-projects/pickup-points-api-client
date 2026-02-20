<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Jozef Liška <jozef.liska (#) develart (.) cz>
 * @copyright 2026 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Exception;

use OlzaLogistic\PpApi\Client\Exception\InvalidResponseStructureException;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class InvalidResponseStructureExceptionTest extends BaseTestCase
{
    public function testWithDefaults(): void
    {
        $exception = new InvalidResponseStructureException();
        
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Invalid response data structure.', $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
    }

    public function testWithCustomMessage(): void
    {
        $message = $this->getRandomString('custom_message');
        $exception = new InvalidResponseStructureException($message);
        
        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
    }

    public function testWithCustomCode(): void
    {
        $message = $this->getRandomString('message');
        $code = $this->getRandomInt(1, 999);
        $exception = new InvalidResponseStructureException($message, $code);
        
        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
    }

    public function testWithPrevious(): void
    {
        $previousException = new \Exception('Previous exception');
        $exception = new InvalidResponseStructureException('Invalid structure', 0, $previousException);
        
        $this->assertSame($previousException, $exception->getPrevious());
    }

} // end of class
