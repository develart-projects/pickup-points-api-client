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

use OlzaLogistic\PpApi\Client\QueryParams;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use OlzaLogistic\PpApi\Client\Tests\Util\Location;

class QueryParamsTest extends BaseTestCase
{
    public function testWithSpeditions(): void
    {
        $speditions = [
            $this->getRandomString('spedition1'),
            $this->getRandomString('spedition2'),
            $this->getRandomString('spedition3'),
        ];
        
        $p = (new QueryParams())->withSpeditions($speditions);
        $value = $p->getSpeditions();
        
        $this->assertIsArray($value);
        $this->assertEquals($speditions, $value);
    }

    public function testGetLocationAsString(): void
    {
        $latitude = Location::getRandomLatitude();
        $longitude = Location::getRandomLongitude();
        
        $p = (new QueryParams())->withLocation($latitude, $longitude);
        $value = $this->callProtectedMethod($p, 'getLocationAsString');
        
        $this->assertIsString($value);
        $expected = sprintf('%f,%f', $latitude, $longitude);
        $this->assertEquals($expected, $value);
    }

    public function testGetLocationAsStringReturnsNullWhenNotSet(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'getLocationAsString');
        
        $this->assertNull($value);
    }

    public function testGetLocationAsStringReturnsNullWhenOnlyLatitudeSet(): void
    {
        $latitude = Location::getRandomLatitude();
        
        $p = (new QueryParams())->withLocation($latitude, null);
        $value = $this->callProtectedMethod($p, 'getLocationAsString');
        
        $this->assertNull($value);
    }

    public function testGetLocationAsStringReturnsNullWhenOnlyLongitudeSet(): void
    {
        $longitude = Location::getRandomLongitude();
        
        $p = (new QueryParams())->withLocation(null, $longitude);
        $value = $this->callProtectedMethod($p, 'getLocationAsString');
        
        $this->assertNull($value);
    }

    public function testSetRequiredFields(): void
    {
        $requiredFields = [
            QueryParams::COUNTRY,
            QueryParams::SPEDITION,
        ];
        
        $p = new QueryParams();
        $result = $p->setRequiredFields($requiredFields);
        
        $this->assertInstanceOf(QueryParams::class, $result);
        $value = $this->callProtectedMethod($p, 'getRequiredFields');
        $this->assertEquals($requiredFields, $value);
    }

    public function testGetRequiredFieldsReturnsEmptyArrayByDefault(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'getRequiredFields');
        
        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    public function testWithSearchQuery(): void
    {
        $searchQuery = $this->getRandomString('search_query');
        
        $p = (new QueryParams())->withSearchQuery($searchQuery);
        $value = $this->callProtectedMethod($p, 'getSearchQuery');
        
        $this->assertIsString($value);
        $this->assertEquals($searchQuery, $value);
    }

    public function testGetSearchQueryReturnsNullByDefault(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'getSearchQuery');
        
        $this->assertNull($value);
    }

    public function testWithLimit(): void
    {
        $limit = $this->getRandomInt(1, 100);
        
        $p = (new QueryParams())->withLimit($limit);
        $value = $this->callProtectedMethod($p, 'getLimit');
        
        $this->assertIsInt($value);
        $this->assertEquals($limit, $value);
    }

    public function testGetLimitReturnsNullByDefault(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'getLimit');
        
        $this->assertNull($value);
    }

    public function testWithLanguage(): void
    {
        $language = $this->getRandomString('lang');
        
        $p = (new QueryParams())->withLanguage($language);
        $value = $this->callProtectedMethod($p, 'getLanguage');
        
        $this->assertIsString($value);
        $this->assertEquals($language, $value);
    }

    public function testGetLanguageReturnsNullByDefault(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'getLanguage');
        
        $this->assertNull($value);
    }

    public function testWithPayment(): void
    {
        $payment = $this->getRandomString('payment');
        
        $p = (new QueryParams())->withPayment($payment);
        $value = $this->callProtectedMethod($p, 'getPayments');
        
        $this->assertIsArray($value);
        $this->assertCount(1, $value);
        $this->assertEquals($payment, $value[0]);
    }

    public function testWithPayments(): void
    {
        $payments = [
            $this->getRandomString('payment1'),
            $this->getRandomString('payment2'),
        ];
        
        $p = (new QueryParams())->withPayments($payments);
        $value = $this->callProtectedMethod($p, 'getPayments');
        
        $this->assertIsArray($value);
        $this->assertCount(2, $value);
        $this->assertEquals($payments, $value);
    }

    public function testGetPaymentsReturnsNullByDefault(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'getPayments');
        
        $this->assertNull($value);
    }

    public function testGetPaymentsAsString(): void
    {
        $payments = [
            $this->getRandomString('payment1'),
            $this->getRandomString('payment2'),
        ];
        $expectedString = implode(',', $payments);
        
        $p = (new QueryParams())->withPayments($payments);
        $value = $this->callProtectedMethod($p, 'getPaymentsAsString');
        
        $this->assertIsString($value);
        $this->assertEquals($expectedString, $value);
    }

    public function testGetPaymentsAsStringReturnsNullWhenNotSet(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'getPaymentsAsString');
        
        $this->assertNull($value);
    }

    public function testWithService(): void
    {
        $service = $this->getRandomString('service');
        
        $p = (new QueryParams())->withService($service);
        $value = $this->callProtectedMethod($p, 'getServices');
        
        $this->assertIsArray($value);
        $this->assertCount(1, $value);
        $this->assertEquals($service, $value[0]);
    }

    public function testWithServices(): void
    {
        $services = [
            $this->getRandomString('service1'),
            $this->getRandomString('service2'),
        ];
        
        $p = (new QueryParams())->withServices($services);
        $value = $this->callProtectedMethod($p, 'getServices');
        
        $this->assertIsArray($value);
        $this->assertCount(2, $value);
        $this->assertEquals($services, $value);
    }

    public function testGetServicesReturnsNullByDefault(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'getServices');
        
        $this->assertNull($value);
    }

    public function testGetServicesAsString(): void
    {
        $services = [
            $this->getRandomString('service1'),
            $this->getRandomString('service2'),
        ];
        $expectedString = implode(',', $services);
        
        $p = (new QueryParams())->withServices($services);
        $value = $this->callProtectedMethod($p, 'getServicesAsString');
        
        $this->assertIsString($value);
        $this->assertEquals($expectedString, $value);
    }

    public function testGetServicesAsStringReturnsNullWhenNotSet(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'getServicesAsString');
        
        $this->assertNull($value);
    }

    public function testArrayToString(): void
    {
        $array = [
            $this->getRandomString('item1'),
            $this->getRandomString('item2'),
            $this->getRandomString('item3'),
        ];
        $expectedString = implode(',', $array);
        
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'arrayToString', [$array]);
        
        $this->assertIsString($value);
        $this->assertEquals($expectedString, $value);
    }

    public function testArrayToStringWithNull(): void
    {
        $p = new QueryParams();
        $value = $this->callProtectedMethod($p, 'arrayToString', [null]);
        
        $this->assertNull($value);
    }

    public function testToQueryStringWithRequiredFields(): void
    {
        $accessToken = $this->getRandomString('token');
        $country = $this->getRandomString('country');
        $spedition = $this->getRandomString('spedition');
        
        $p = (new QueryParams())
            ->withAccessToken($accessToken)
            ->withCountry($country)
            ->withSpedition($spedition);
        
        $p->setRequiredFields([
            QueryParams::ACCESS_TOKEN,
            QueryParams::COUNTRY,
            QueryParams::SPEDITION,
        ]);
        
        $queryString = $p->toQueryString();
        
        $this->assertIsString($queryString);
        $this->assertStringContainsString('access_token=', $queryString);
        $this->assertStringContainsString('country=', $queryString);
        $this->assertStringContainsString('spedition=', $queryString);
    }

    public function testToQueryStringThrowsExceptionWhenRequiredFieldMissing(): void
    {
        $p = new QueryParams();
        
        $p->setRequiredFields([
            QueryParams::COUNTRY,
        ]);
        
        $this->expectException(\InvalidArgumentException::class);
        $p->toQueryString();
    }

    public function testValidateThrowsExceptionForUnknownField(): void
    {
        $p = new QueryParams();
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown field');
        $this->callProtectedMethod($p, 'validate', [['unknown_field']]);
    }

    public function testValidateLocationWithInvalidLatitude(): void
    {
        $p = (new QueryParams())->withLocation(91.0, 0.0);
        
        $this->expectException(\InvalidArgumentException::class);
        $this->callProtectedMethod($p, 'validate', [[QueryParams::LOCATION]]);
    }

    public function testValidateLocationWithInvalidLongitude(): void
    {
        $p = (new QueryParams())->withLocation(0.0, 181.0);
        
        $this->expectException(\InvalidArgumentException::class);
        $this->callProtectedMethod($p, 'validate', [[QueryParams::LOCATION]]);
    }

} // end of class
