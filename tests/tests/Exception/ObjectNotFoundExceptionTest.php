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

use OlzaLogistic\PpApi\Client\ApiCode;
use OlzaLogistic\PpApi\Client\Exception\MethodFailedException;
use OlzaLogistic\PpApi\Client\Exception\ObjectNotFoundException;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class ObjectNotFoundExceptionTest extends BaseTestCase
{
    public function testWithDefaults(): void
    {
        $exception = new ObjectNotFoundException();
        
        $this->assertInstanceOf(MethodFailedException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Object not found', $exception->getMessage());
        $this->assertEquals(ApiCode::ERROR_OBJECT_NOT_FOUND, $exception->getCode());
    }

    public function testWithCustomReason(): void
    {
        $reason = $this->getRandomString('custom_reason');
        $exception = new ObjectNotFoundException($reason);
        
        $this->assertEquals($reason, $exception->getMessage());
        $this->assertEquals(ApiCode::ERROR_OBJECT_NOT_FOUND, $exception->getCode());
    }

    public function testWithCustomCode(): void
    {
        $reason = $this->getRandomString('reason');
        $code = $this->getRandomInt(1, 999);
        $exception = new ObjectNotFoundException($reason, $code);
        
        $this->assertEquals($reason, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
    }

    public function testWithPrevious(): void
    {
        $previousException = new \Exception('Previous exception');
        $exception = new ObjectNotFoundException('Object not found', ApiCode::ERROR_OBJECT_NOT_FOUND, $previousException);
        
        $this->assertSame($previousException, $exception->getPrevious());
    }

} // end of class
