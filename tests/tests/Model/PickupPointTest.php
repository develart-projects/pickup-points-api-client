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
            $this->addWarning('Hours are not tested');
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
        unset($actual[PP::KEY_GROUP_HOURS]);
        $this->addWarning('Hours are not tested');
        Assert::assertEquals($expected, $actual);
    }

} // end of class
