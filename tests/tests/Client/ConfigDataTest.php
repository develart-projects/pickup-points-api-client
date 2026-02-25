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

use OlzaLogistic\PpApi\Client\ConfigData;
use OlzaLogistic\PpApi\Client\Model\Spedition;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class ConfigDataTest extends BaseTestCase
{
    public function testGetConfigItemsReturnsEmptyArrayByDefault(): void
    {
        $configData = new ConfigData();
        
        $result = $configData->getConfigItems();
        
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testAddConfigItem(): void
    {
        $configData = new ConfigData();
        $key = $this->getRandomString('config_key');
        $value = $this->getRandomString('config_value');
        
        $result = $configData->addConfigItem($key, $value);
        
        $this->assertInstanceOf(ConfigData::class, $result);
        $items = $configData->getConfigItems();
        $this->assertArrayHasKey($key, $items);
        $this->assertEquals($value, $items[$key]);
    }

    public function testAddConfigItemWithDifferentTypes(): void
    {
        $configData = new ConfigData();
        
        $stringKey = $this->getRandomString('str_key');
        $stringValue = $this->getRandomString('str_value');
        $configData->addConfigItem($stringKey, $stringValue);
        
        $intKey = $this->getRandomString('int_key');
        $intValue = $this->getRandomInt(1, 100);
        $configData->addConfigItem($intKey, $intValue);
        
        $boolKey = $this->getRandomString('bool_key');
        $boolValue = $this->getRandomBool();
        $configData->addConfigItem($boolKey, $boolValue);
        
        $arrayKey = $this->getRandomString('array_key');
        $arrayValue = [$this->getRandomString('item1'), $this->getRandomString('item2')];
        $configData->addConfigItem($arrayKey, $arrayValue);
        
        $items = $configData->getConfigItems();
        $this->assertEquals($stringValue, $items[$stringKey]);
        $this->assertEquals($intValue, $items[$intKey]);
        $this->assertEquals($boolValue, $items[$boolKey]);
        $this->assertEquals($arrayValue, $items[$arrayKey]);
    }

    public function testAddConfigItems(): void
    {
        $configData = new ConfigData();
        $items = [
            $this->getRandomString('key1') => $this->getRandomString('value1'),
            $this->getRandomString('key2') => $this->getRandomInt(1, 100),
            $this->getRandomString('key3') => $this->getRandomBool(),
        ];
        
        $result = $configData->addConfigItems($items);
        
        $this->assertInstanceOf(ConfigData::class, $result);
        $configItems = $configData->getConfigItems();
        
        foreach ($items as $key => $value) {
            $this->assertArrayHasKey($key, $configItems);
            $this->assertEquals($value, $configItems[$key]);
        }
    }

    public function testAddConfigItemsWithEmptyArray(): void
    {
        $configData = new ConfigData();
        
        $result = $configData->addConfigItems([]);
        
        $this->assertInstanceOf(ConfigData::class, $result);
        $items = $configData->getConfigItems();
        $this->assertEmpty($items);
    }

    public function testGetSpeditionsReturnsEmptyArrayByDefault(): void
    {
        $configData = new ConfigData();
        
        $result = $configData->getSpeditions();
        
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testAddSpedition(): void
    {
        $configData = new ConfigData();
        $speditionCode = $this->getRandomString('spedition_code');
        
        $spedition = Spedition::fromApiResponse([
            Spedition::KEY_CODE => $speditionCode,
            Spedition::KEY_LABEL => $this->getRandomString('label'),
            Spedition::KEY_NAMES => [],
        ]);
        
        $result = $configData->addSpedition($spedition);
        
        $this->assertInstanceOf(ConfigData::class, $result);
        $speditions = $configData->getSpeditions();
        $this->assertArrayHasKey($speditionCode, $speditions);
        $this->assertInstanceOf(Spedition::class, $speditions[$speditionCode]);
        $this->assertEquals($speditionCode, $speditions[$speditionCode]->getCode());
    }

    public function testAddMultipleSpeditions(): void
    {
        $configData = new ConfigData();
        
        $code1 = $this->getRandomString('code1');
        $spedition1 = Spedition::fromApiResponse([
            Spedition::KEY_CODE => $code1,
            Spedition::KEY_LABEL => $this->getRandomString('label1'),
            Spedition::KEY_NAMES => [],
        ]);
        
        $code2 = $this->getRandomString('code2');
        $spedition2 = Spedition::fromApiResponse([
            Spedition::KEY_CODE => $code2,
            Spedition::KEY_LABEL => $this->getRandomString('label2'),
            Spedition::KEY_NAMES => [],
        ]);
        
        $configData->addSpedition($spedition1);
        $configData->addSpedition($spedition2);
        
        $speditions = $configData->getSpeditions();
        $this->assertCount(2, $speditions);
        $this->assertArrayHasKey($code1, $speditions);
        $this->assertArrayHasKey($code2, $speditions);
    }

    public function testToArrayWithConfigItems(): void
    {
        $configData = new ConfigData();
        $key = $this->getRandomString('config_key');
        $value = $this->getRandomString('config_value');
        
        $configData->addConfigItem($key, $value);
        
        $result = $configData->toArray();
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('config', $result);
        $this->assertArrayHasKey($key, $result['config']);
        $this->assertEquals($value, $result['config'][$key]);
    }

    public function testToArrayWithSpeditions(): void
    {
        $configData = new ConfigData();
        $speditionCode = $this->getRandomString('spedition_code');
        
        $spedition = Spedition::fromApiResponse([
            Spedition::KEY_CODE => $speditionCode,
            Spedition::KEY_LABEL => $this->getRandomString('label'),
            Spedition::KEY_NAMES => [],
        ]);
        
        $configData->addSpedition($spedition);
        
        $result = $configData->toArray();
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('speditions', $result);
        $this->assertArrayHasKey($speditionCode, $result['speditions']);
        $this->assertIsArray($result['speditions'][$speditionCode]);
    }

    public function testToArrayWithConfigAndSpeditions(): void
    {
        $configData = new ConfigData();
        
        $configKey = $this->getRandomString('config_key');
        $configValue = $this->getRandomString('config_value');
        $configData->addConfigItem($configKey, $configValue);
        
        $speditionCode = $this->getRandomString('spedition_code');
        $spedition = Spedition::fromApiResponse([
            Spedition::KEY_CODE => $speditionCode,
            Spedition::KEY_LABEL => $this->getRandomString('label'),
            Spedition::KEY_NAMES => [],
        ]);
        $configData->addSpedition($spedition);
        
        $result = $configData->toArray();
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('config', $result);
        $this->assertArrayHasKey('speditions', $result);
        $this->assertArrayHasKey($configKey, $result['config']);
        $this->assertArrayHasKey($speditionCode, $result['speditions']);
    }

    public function testToArrayWithEmptyData(): void
    {
        $configData = new ConfigData();
        
        $result = $configData->toArray();
        
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

} // end of class
