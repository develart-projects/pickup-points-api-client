<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Model;

use OlzaLogistic\PpApi\Client\Contracts\ArrayableContract;
use OlzaLogistic\PpApi\Client\Model\PickupPoint as PP;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use OlzaLogistic\PpApi\Client\Tests\Util\Lockpick;
use OlzaLogistic\PpApi\Client\Tests\Util\PickupPointResponseGenerator;
use PHPUnit\Framework\Assert;

class PickupPointTest extends BaseTestCase
{
    public function testResponseParsing(): void
    {
        $data = PickupPointResponseGenerator::data()
            ->withAll()
            ->get();
        $pp = PP::fromApiResponse($data);

        $this->assertModelMatchesData($data, $pp);
    }

    /* ****************************************************************************************** */

    protected function assertModelMatchesData(array $expected, PP $pp): void
    {
        $this->assertEquals($expected[ PP::KEY_ID ], $pp->getSpeditionId());
        $this->assertEquals($expected[ PP::KEY_SPEDITION ], $pp->getSpedition());
        $this->assertEquals($expected[ PP::KEY_TYPE ], $pp->getType());

        if (\array_key_exists(PP::KEY_GROUP_NAME, $expected)) {
            $nameLines = $expected[ PP::KEY_GROUP_NAME ];
            $this->assertCount(\count($nameLines), $pp->getNames());
            foreach ($pp->getNames() as $name) {
                $this->assertEquals(\array_shift($nameLines), $name);
            }
        }

        if (\array_key_exists(PP::KEY_GROUP_CONTACTS, $expected)) {
            $node = $expected[ PP::KEY_GROUP_CONTACTS ];
            $this->assertEquals($node[ PP::KEY_EMAIL ], $pp->getEmail());
            $this->assertEquals($node[ PP::KEY_PHONE ], $pp->getPhone());
        }

        if (\array_key_exists(PP::KEY_GROUP_HOURS, $expected)) {
            $hoursGroup = $expected[PP::KEY_GROUP_HOURS];
            
            // test open247 flag
            if (\array_key_exists(PP::KEY_OPEN_247, $hoursGroup)) {
                $this->assertEquals($hoursGroup[PP::KEY_OPEN_247], $pp->isOpen247());
            }
            
            // test Monday
            if (\array_key_exists(PP::KEY_MONDAY, $hoursGroup)) {
                $day = $hoursGroup[PP::KEY_MONDAY];
                $this->assertEquals($day[PP::KEY_HOURS] ?? null, $pp->getMondayHours());
                $this->assertEquals($day[PP::KEY_BREAK] ?? null, $pp->getMondayBreak());
            }
            
            // test Tuesday
            if (\array_key_exists(PP::KEY_TUESDAY, $hoursGroup)) {
                $day = $hoursGroup[PP::KEY_TUESDAY];
                $this->assertEquals($day[PP::KEY_HOURS] ?? null, $pp->getTuesdayHours());
                $this->assertEquals($day[PP::KEY_BREAK] ?? null, $pp->getTuesdayBreak());
            }
            
            // test Wednesday
            if (\array_key_exists(PP::KEY_WEDNESDAY, $hoursGroup)) {
                $day = $hoursGroup[PP::KEY_WEDNESDAY];
                $this->assertEquals($day[PP::KEY_HOURS] ?? null, $pp->getWednesdayHours());
                $this->assertEquals($day[PP::KEY_BREAK] ?? null, $pp->getWednesdayBreak());
            }
            
            // test Thursday
            if (\array_key_exists(PP::KEY_THURSDAY, $hoursGroup)) {
                $day = $hoursGroup[PP::KEY_THURSDAY];
                $this->assertEquals($day[PP::KEY_HOURS] ?? null, $pp->getThursdayHours());
                $this->assertEquals($day[PP::KEY_BREAK] ?? null, $pp->getThursdayBreak());
            }
            
            // test Friday
            if (\array_key_exists(PP::KEY_FRIDAY, $hoursGroup)) {
                $day = $hoursGroup[PP::KEY_FRIDAY];
                $this->assertEquals($day[PP::KEY_HOURS] ?? null, $pp->getFridayHours());
                $this->assertEquals($day[PP::KEY_BREAK] ?? null, $pp->getFridayBreak());
            }
            
            // test Saturday
            if (\array_key_exists(PP::KEY_SATURDAY, $hoursGroup)) {
                $day = $hoursGroup[PP::KEY_SATURDAY];
                $this->assertEquals($day[PP::KEY_HOURS] ?? null, $pp->getSaturdayHours());
                $this->assertEquals($day[PP::KEY_BREAK] ?? null, $pp->getSaturdayBreak());
            }
            
            // test Sunday
            if (\array_key_exists(PP::KEY_SUNDAY, $hoursGroup)) {
                $day = $hoursGroup[PP::KEY_SUNDAY];
                $this->assertEquals($day[PP::KEY_HOURS] ?? null, $pp->getSundayHours());
                $this->assertEquals($day[PP::KEY_BREAK] ?? null, $pp->getSundayBreak());
            }
        }

        if (\array_key_exists(PP::KEY_GROUP_LOCATION, $expected)) {
            $node = $expected[ PP::KEY_GROUP_LOCATION ];
            $this->assertEquals((string)$node[ PP::KEY_LATITUDE ], $pp->getLatitude());
            $this->assertEquals((string)$node[ PP::KEY_LONGITUDE ], $pp->getLongitude());
        }
    }

    /* ****************************************************************************************** */

    public function testArrayable(): void
    {
        $data = PickupPointResponseGenerator::data()
                                            ->withAll()
                                            ->get();
        $pp = PP::fromApiResponse($data);

        $expected = $data;
        unset($expected[PP::KEY_GROUP_SERVICES]);
        $expected[PP::KEY_GROUP_LOCATION][PP::KEY_LATITUDE]
            = \strval($expected[PP::KEY_GROUP_LOCATION][PP::KEY_LATITUDE]);
        $expected[PP::KEY_GROUP_LOCATION][PP::KEY_LONGITUDE]
            = \strval($expected[PP::KEY_GROUP_LOCATION][PP::KEY_LONGITUDE]);
        Assert::assertInstanceof(ArrayableContract::class, $pp);

        $actual = $pp->toArray();
        Assert::assertEquals($expected, $actual);
    }

    /* ****************************************************************************************** */

    public function testSetName2IsPopulatedFromApiResponse(): void
    {
        $data = PickupPointResponseGenerator::data()
            ->withNames(2)
            ->get();
        $pp = PP::fromApiResponse($data);

        $this->assertEquals($data[PP::KEY_GROUP_NAME][1], $pp->getName2());
    }

    /* ****************************************************************************************** */

    public function testGetAddressReturnsAllFields(): void
    {
        $data = PickupPointResponseGenerator::data()
            ->withAddress()
            ->get();
        $pp = PP::fromApiResponse($data);

        $address = $pp->getAddress();
        $node = $data[PP::KEY_GROUP_ADDRESS];

        $this->assertArrayHasKey(PP::KEY_FULL_ADDRESS, $address);
        $this->assertEquals($node[PP::KEY_FULL_ADDRESS], $address[PP::KEY_FULL_ADDRESS]);
        $this->assertArrayHasKey(PP::KEY_STREET, $address);
        $this->assertArrayHasKey(PP::KEY_CITY, $address);
        $this->assertArrayHasKey(PP::KEY_ZIP, $address);
    }

    public function testGetAddressFiltersNullValues(): void
    {
        $data = PickupPointResponseGenerator::data()
            ->withAddress(true)
            ->get();
        $pp = PP::fromApiResponse($data);

        $address = $pp->getAddress();

        // full address must be present; null-valued fields must be filtered out
        $this->assertArrayHasKey(PP::KEY_FULL_ADDRESS, $address);
        $this->assertArrayNotHasKey(PP::KEY_STREET, $address);
        $this->assertArrayNotHasKey(PP::KEY_ZIP, $address);
        $this->assertArrayNotHasKey(PP::KEY_CITY, $address);
        $this->assertArrayNotHasKey(PP::KEY_COUNTY, $address);
    }

    /* ****************************************************************************************** */

    public function testGetContactsReturnsArray(): void
    {
        $data = PickupPointResponseGenerator::data()
            ->withContacts()
            ->get();
        $pp = PP::fromApiResponse($data);

        $contacts = $pp->getContacts();

        $this->assertArrayHasKey(PP::KEY_PHONE, $contacts);
        $this->assertArrayHasKey(PP::KEY_EMAIL, $contacts);
        $this->assertEquals($data[PP::KEY_GROUP_CONTACTS][PP::KEY_PHONE], $contacts[PP::KEY_PHONE]);
        $this->assertEquals($data[PP::KEY_GROUP_CONTACTS][PP::KEY_EMAIL], $contacts[PP::KEY_EMAIL]);
    }

    /* ****************************************************************************************** */

    public function testSetOpen247(): void
    {
        $pp = PP::fromApiResponse(PickupPointResponseGenerator::data()->get());

        $this->assertFalse($pp->isOpen247());

        $pp->setOpen247(true);
        $this->assertTrue($pp->isOpen247());

        $pp->setOpen247(false);
        $this->assertFalse($pp->isOpen247());
    }

    /* ****************************************************************************************** */

    public function testGetLocationReturnsArrayWhenCoordinatesSet(): void
    {
        $data = PickupPointResponseGenerator::data()
            ->withLocation()
            ->get();
        $pp = PP::fromApiResponse($data);

        $location = $pp->getLocation();

        $this->assertNotNull($location);
        $this->assertArrayHasKey(PP::KEY_LATITUDE, $location);
        $this->assertArrayHasKey(PP::KEY_LONGITUDE, $location);
        $this->assertEquals($pp->getLatitude(), $location[PP::KEY_LATITUDE]);
        $this->assertEquals($pp->getLongitude(), $location[PP::KEY_LONGITUDE]);
    }

    public function testGetLocationReturnsNullWhenNoCoordinates(): void
    {
        // PP created without location – latitude/longitude stay null
        $pp = PP::fromApiResponse(PickupPointResponseGenerator::data()->get());

        $this->assertNull($pp->getLocation());
    }

    /* ****************************************************************************************** */

    public function testGetNotesReturnsNullByDefault(): void
    {
        $pp = PP::fromApiResponse(PickupPointResponseGenerator::data()->get());

        $this->assertNull($pp->getNotes());
    }

    public function testSetNotes(): void
    {
        $pp = PP::fromApiResponse(PickupPointResponseGenerator::data()->get());
        $expected = 'Test note';

        Lockpick::call($pp, 'setNotes', [$expected]);

        $this->assertEquals($expected, $pp->getNotes());
    }

    public function testSetNotesAcceptsNull(): void
    {
        $pp = PP::fromApiResponse(PickupPointResponseGenerator::data()->get());

        Lockpick::call($pp, 'setNotes', ['initial']);
        Lockpick::call($pp, 'setNotes', [null]);

        $this->assertNull($pp->getNotes());
    }

    /* ****************************************************************************************** */

    public function testGetHoursWithFilterExcludesEmptyDays(): void
    {
        // only Monday
        $data = PickupPointResponseGenerator::data()
            ->withHours(false, [PP::KEY_MONDAY])
            ->get();
        $pp = PP::fromApiResponse($data);

        $filtered = $pp->getHours(true);

        $this->assertArrayHasKey(PP::KEY_OPEN_247, $filtered);
        $this->assertArrayHasKey(PP::KEY_MONDAY, $filtered);
        $this->assertArrayNotHasKey(PP::KEY_TUESDAY, $filtered);
        $this->assertArrayNotHasKey(PP::KEY_WEDNESDAY, $filtered);
        $this->assertArrayNotHasKey(PP::KEY_THURSDAY, $filtered);
        $this->assertArrayNotHasKey(PP::KEY_FRIDAY, $filtered);
        $this->assertArrayNotHasKey(PP::KEY_SATURDAY, $filtered);
        $this->assertArrayNotHasKey(PP::KEY_SUNDAY, $filtered);
    }

} // end of class
