<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Jozef Liška <jozef.liska (#) develart (.) cz>
 * @copyright 2026 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Model;

use OlzaLogistic\PpApi\Client\PostParams;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class PostParamsTest extends BaseTestCase
{
    public function testSetJsonWithValidJson(): void
    {
        $params = new PostParams();
        $jsonData = ['key' => $this->getRandomString('value')];
        $jsonString = (string)\json_encode($jsonData);
        
        $params->setJson($jsonString);
        
        $this->assertTrue($params->hasJson());
        $this->assertEquals($jsonString, $params->getJson());
    }

    public function testSetJsonWithEmptyObject(): void
    {
        $params = new PostParams();
        $jsonString = '{}';
        
        $params->setJson($jsonString);
        
        $this->assertTrue($params->hasJson());
        $this->assertEquals($jsonString, $params->getJson());
    }

    public function testSetJsonWithEmptyArray(): void
    {
        $params = new PostParams();
        $jsonString = '[]';
        
        $params->setJson($jsonString);
        
        $this->assertTrue($params->hasJson());
        $this->assertEquals($jsonString, $params->getJson());
    }

    public function testSetJsonWithComplexData(): void
    {
        $params = new PostParams();
        $complexData = [
            'string' => $this->getRandomString('str'),
            'number' => $this->getRandomInt(1, 1000),
            'bool' => $this->getRandomBool(),
            'null' => null,
            'array' => [$this->getRandomString('item1'), $this->getRandomString('item2')],
            'nested' => [
                'key' => $this->getRandomString('nested_value'),
            ],
        ];
        $jsonString = (string)\json_encode($complexData);
        
        $params->setJson($jsonString);
        
        $this->assertTrue($params->hasJson());
        $this->assertEquals($jsonString, $params->getJson());
    }

    public function testSetJsonWithInvalidJson(): void
    {
        $params = new PostParams();
        $invalidJson = '{invalid json}';
        
        $this->expectException(\InvalidArgumentException::class);
        $params->setJson($invalidJson);
    }

    public function testSetJsonWithEmptyString(): void
    {
        $params = new PostParams();
        $invalidJson = '';
        
        $this->expectException(\InvalidArgumentException::class);
        $params->setJson($invalidJson);
    }

    public function testSetJsonWithNonJson(): void
    {
        $params = new PostParams();
        $nonJson = $this->getRandomString('not_json');
        
        $this->expectException(\InvalidArgumentException::class);
        $params->setJson($nonJson);
    }

    public function testHasJsonReturnsFalseByDefault(): void
    {
        $params = new PostParams();
        
        $this->assertFalse($params->hasJson());
    }

    public function testGetJsonThrowsExceptionWhenNotSet(): void
    {
        $params = new PostParams();
        
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('JSON value not set');
        $params->getJson();
    }

    public function testSetJsonMultipleTimes(): void
    {
        $params = new PostParams();
        
        $firstJson = (string)\json_encode(['first' => $this->getRandomString('value1')]);
        $params->setJson($firstJson);
        $this->assertEquals($firstJson, $params->getJson());
        
        $secondJson = (string)\json_encode(['second' => $this->getRandomString('value2')]);
        $params->setJson($secondJson);
        $this->assertEquals($secondJson, $params->getJson());
        $this->assertTrue($params->hasJson());
    }

} // end of class
