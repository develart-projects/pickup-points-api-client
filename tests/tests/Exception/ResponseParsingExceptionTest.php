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

use OlzaLogistic\PpApi\Client\Exception\ResponseParsingException;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class ResponseParsingExceptionTest extends BaseTestCase
{
    public function testWithDefaults(): void
    {
        $exception = new ResponseParsingException();
        
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Failed parsing API response.', $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
    }

    public function testWithCustomMessage(): void
    {
        $message = $this->getRandomString('custom_message');
        $exception = new ResponseParsingException($message);
        
        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
    }

    public function testWithCustomCode(): void
    {
        $message = $this->getRandomString('message');
        $code = $this->getRandomInt(1, 999);
        $exception = new ResponseParsingException($message, $code);
        
        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
    }

    public function testWithPrevious(): void
    {
        $previousException = new \Exception('Previous exception');
        $exception = new ResponseParsingException('Parsing failed', 0, $previousException);
        
        $this->assertSame($previousException, $exception->getPrevious());
    }

} // end of class
