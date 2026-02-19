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

} // end of class
