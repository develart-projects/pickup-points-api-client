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

use OlzaLogistic\PpApi\Client\Exception\ClientNotSealedException;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class ClientNotSealedExceptionTest extends BaseTestCase
{
    public function testException(): void
    {
        $exception = new ClientNotSealedException();
        
        $this->assertInstanceOf(\LogicException::class, $exception);
        $this->assertEquals('Client configuration not sealed', $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
    }

} // end of class
