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

use OlzaLogistic\PpApi\Client\Exception\MethodFailedException;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class MethodFailedExceptionTest extends BaseTestCase
{
    public function testWithDefaults(): void
    {
        $exception = new MethodFailedException();
        
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('API method failed', $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
    }

    public function testWithCustomReason(): void
    {
        $reason = $this->getRandomString('custom_reason');
        $exception = new MethodFailedException($reason);
        
        $this->assertEquals($reason, $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
    }

    public function testWithCustomCode(): void
    {
        $reason = $this->getRandomString('reason');
        $code = $this->getRandomInt(1, 999);
        $exception = new MethodFailedException($reason, $code);
        
        $this->assertEquals($reason, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
    }

    public function testWithPrevious(): void
    {
        $previousException = new \Exception('Previous exception');
        $exception = new MethodFailedException('Method failed', 0, $previousException);
        
        $this->assertSame($previousException, $exception->getPrevious());
    }

} // end of class
