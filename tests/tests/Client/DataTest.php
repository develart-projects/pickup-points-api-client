<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Jozef Liška <jozef.liska (#) develart (.) cz>
 * @copyright 2026 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Client;

use OlzaLogistic\PpApi\Client\Data;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class DataTest extends BaseTestCase
{
    public function testToArrayWithSimpleData(): void
    {
        $data = new Data();
        $key = $this->getRandomString('key');
        $value = $this->getRandomString('value');
        
        $data[$key] = $value;
        
        $result = $data->toArray();
        $this->assertIsArray($result);
        $this->assertArrayHasKey($key, $result);
        $this->assertEquals($value, $result[$key]);
    }

    public function testToArrayWithMultipleItems(): void
    {
        $data = new Data();
        $items = [
            $this->getRandomString('key1') => $this->getRandomString('value1'),
            $this->getRandomString('key2') => $this->getRandomInt(1, 100),
            $this->getRandomString('key3') => $this->getRandomBool(),
        ];
        
        foreach ($items as $key => $value) {
            $data[$key] = $value;
        }
        
        $result = $data->toArray();
        $this->assertIsArray($result);
        $this->assertCount(count($items), $result);
        
        foreach ($items as $key => $value) {
            $this->assertArrayHasKey($key, $result);
            $this->assertEquals($value, $result[$key]);
        }
    }

    public function testToArrayWithArrayableContract(): void
    {
        $data = new Data();
        $key = $this->getRandomString('key');
        
        $nestedData = new Data();
        $nestedKey = $this->getRandomString('nested_key');
        $nestedValue = $this->getRandomString('nested_value');
        $nestedData[$nestedKey] = $nestedValue;
        
        $data[$key] = $nestedData;
        
        $result = $data->toArray();
        $this->assertIsArray($result);
        $this->assertArrayHasKey($key, $result);
        $this->assertIsArray($result[$key]);
        $this->assertArrayHasKey($nestedKey, $result[$key]);
        $this->assertEquals($nestedValue, $result[$key][$nestedKey]);
    }

    public function testToArrayWithArrayObject(): void
    {
        $data = new Data();
        $key = $this->getRandomString('key');
        
        $arrayObject = new \ArrayObject([
            $this->getRandomString('sub_key') => $this->getRandomString('sub_value'),
        ]);
        
        $data[$key] = $arrayObject;
        
        $result = $data->toArray();
        $this->assertIsArray($result);
        $this->assertArrayHasKey($key, $result);
        $this->assertIsArray($result[$key]);
    }

    public function testToArrayWithObject(): void
    {
        $data = new Data();
        $key = $this->getRandomString('key');
        
        $object = new \stdClass();
        $data[$key] = $object;
        
        $result = $data->toArray();
        $this->assertIsArray($result);
        $this->assertArrayHasKey($key, $result);
        $this->assertIsString($result[$key]);
        $this->assertStringContainsString('<stdClass>', $result[$key]);
    }

    public function testToArrayWithEmptyData(): void
    {
        $data = new Data();
        
        $result = $data->toArray();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

} // end of class
