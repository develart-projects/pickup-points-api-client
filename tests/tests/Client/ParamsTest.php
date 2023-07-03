<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Model;

use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use OlzaLogistic\PpApi\Client\Tests\Util\Location;

class ParamsTest extends BaseTestCase
{
    public function testCreate(): void
    {
        $p = Params::create();
        $this->assertInstanceOf(Params::class, $p);
    }

    public function testWithAccessToken(): void
    {
        $accessToken = $this->getRandomString('token');
        $p = Params::create()->withAccessToken($accessToken);
        $value = $this->callProtectedMethod($p, 'getAccessToken');
        $this->assertIsString($value);
        $this->assertEquals($accessToken, $value);
    }

    public function testCountry(): void
    {
        $expected = $this->getRandomString('country');
        $p = Params::create()->withCountry($expected);
        $value = $this->callProtectedMethod($p, 'getCountry');
        $this->assertIsString($value);
        $this->assertEquals($expected, $value);
    }

    public function testCity(): void
    {
        $expected = $this->getRandomString('city');
        $p = Params::create()->withCity($expected);
        $value = $this->callProtectedMethod($p, 'getCity');
        $this->assertIsString($value);
        $this->assertEquals($expected, $value);
    }

    public function testSpedition(): void
    {
        $expected = $this->getRandomString('spedition');
        $p = Params::create()->withSpedition($expected);
        $value = $this->callProtectedMethod($p, 'getSpeditions');
        $this->assertIsArray($value);
        /** @var array $value */
        $this->assertCount(1, $value);
        $this->assertEquals($expected, $value[0]);
    }

    public function testSpeditionId(): void
    {
        $expected = $this->getRandomString('speditionId');
        $p = Params::create()->withSpeditionId($expected);
        $value = $this->callProtectedMethod($p, 'getSpeditionId');
        $this->assertIsString($value);
        $this->assertEquals($expected, $value);
    }

    public function testLocation(): void
    {
        $latitude = Location::getRandomLongitude();
        $longitude = Location::getRandomLatitude();
        $p = Params::create()->withLocation($latitude, $longitude);
        $value = $this->callProtectedMethod($p, 'getLatitude');
        $this->assertIsFloat($value);
        $this->assertEquals($latitude, $value);
        $value = $this->callProtectedMethod($p, 'getLongitude');
        $this->assertIsFloat($value);
        $this->assertEquals($longitude, $value);
    }

    public function testWithFields(): void
    {
        $fields = [];
        $cnt = $this->getRandomInt(5, 25);
        for ($i = 0; $i < $cnt; $i++) {
            $fields[] = $this->getRandomString("field_{$i}");
        }
        $p = Params::create()->withFields($fields);
        $value = $this->callProtectedMethod($p, 'getFields');
        $this->assertIsArray($value);
        /**
         * @var array $fields
         * @var array $value
         */
        $this->assertArrayEquals($fields, $value);
    }

    public function testGetFieldsAsString(): void
    {
        $fields = [];
        $cnt = $this->getRandomInt(5, 25);
        for ($i = 0; $i < $cnt; $i++) {
            $fields[] = $this->getRandomString("field_{$i}");
        }
        $fieldsAsString = \implode(',', $fields);

        $p = Params::create()->withFields($fields);
        $value = $this->callProtectedMethod($p, 'getFieldsAsString');
        $this->assertEquals($fieldsAsString, $value);
    }

    public function testAddField(): void
    {
        $fields = [];
        $p = Params::create();

        $cnt = $this->getRandomInt(5, 25);
        for ($i = 0; $i < $cnt; $i++) {
            $field = $this->getRandomString("field_{$i}");
            $p->addField($field);
            $fields[] = $field;
        }
        $value = $this->callProtectedMethod($p, 'getFields');
        $this->assertIsArray($value);
        /** @var array $value */
        $this->assertArrayEquals($fields, $value);
    }

} // end of class
