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

use OlzaLogistic\PpApi\Client\Exception\ClientAlreadyInitializedException;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class ClientAlreadyInitializedExceptionTest extends BaseTestCase
{
    public function testException(): void
    {
        $exception = new ClientAlreadyInitializedException();
        
        $this->assertInstanceOf(\LogicException::class, $exception);
        $this->assertEquals('Client already initialized', $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
    }

} // end of class
