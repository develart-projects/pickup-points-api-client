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
use OlzaLogistic\PpApi\Client\Exception\AccessDeniedException;
use OlzaLogistic\PpApi\Client\Exception\MethodFailedException;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class AccessDeniedExceptionTest extends BaseTestCase
{
    public function testWithDefaults(): void
    {
        $exception = new AccessDeniedException();
        
        $this->assertInstanceOf(MethodFailedException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Access denied', $exception->getMessage());
        $this->assertEquals(ApiCode::ERROR_ACCESS_DENIED, $exception->getCode());
    }

    public function testWithCustomReason(): void
    {
        $reason = $this->getRandomString('custom_reason');
        $exception = new AccessDeniedException($reason);
        
        $this->assertEquals($reason, $exception->getMessage());
        $this->assertEquals(ApiCode::ERROR_ACCESS_DENIED, $exception->getCode());
    }

    public function testWithCustomCode(): void
    {
        $reason = $this->getRandomString('reason');
        $code = $this->getRandomInt(1, 999);
        $exception = new AccessDeniedException($reason, $code);
        
        $this->assertEquals($reason, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
    }

    public function testWithPrevious(): void
    {
        $previousException = new \Exception('Previous exception');
        $exception = new AccessDeniedException('Access denied', ApiCode::ERROR_ACCESS_DENIED, $previousException);
        
        $this->assertSame($previousException, $exception->getPrevious());
    }

} // end of class
