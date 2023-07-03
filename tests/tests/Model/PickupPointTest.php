<?php

namespace OlzaLogistic\PpApi\Client\Tests\Model;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\Model\PickupPoint as PP;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use OlzaLogistic\PpApi\Client\Tests\Util\PickupPointResponseGenerator;

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
            $this->assertEquals($node[ PP::KEY_LATITUDE ], $pp->getLatitude());
            $this->assertEquals($node[ PP::KEY_LONGITUDE ], $pp->getLongitude());
        }
    }

} // end of class
