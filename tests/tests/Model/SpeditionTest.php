<?php

namespace OlzaLogistic\PpApi\Client\Tests\Model;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2021-2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\Model\Spedition;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class SpeditionTest extends BaseTestCase
{
    public function testResponseParsing(): void
    {
        $country = $this->getRandomString('ctry');
        $count = $this->getRandomInt(1, 10);
        foreach ($this->generateSpeditionData($country, $count) as $spedData) {
            $code = $spedData[ Spedition::KEY_CODE ];
            $country = $spedData[ Spedition::KEY_COUNTRY ];
            $label = $spedData[ Spedition::KEY_LABEL ];
            $spedition = $spedData[ Spedition::KEY_SPEDITION ];

            $sped = Spedition::fromApiResponse($spedData);

            $this->assertEquals($code, $sped->getCode());
            $this->assertEquals($country, $sped->getCountry());
            $this->assertEquals($label, $sped->getLabel());
            $this->assertEquals($spedition, $sped->getSpedition());
        }
    }

    /* ****************************************************************************************** */

    /**
     * Returns Generator yielding random Spedition source data.
     *
     * @param string $country Country code to use in yielded data.
     * @param int    $count   Number of elements to yield.
     *
     * @return \Generator
     */
    protected function generateSpeditionData(string $country, int $count): \Generator
    {
        for ($i = 0; $i < $count; $i++) {
            $spedCodeBase = $this->getRandomString('code', 12);

            yield [
                Spedition::KEY_CODE      => "{$spedCodeBase}{$i}",
                Spedition::KEY_COUNTRY   => $country,
                Spedition::KEY_LABEL     => $this->getRandomString('label'),
                Spedition::KEY_SPEDITION => $this->getRandomString('sped'),
            ];
        }
    }

} // end of class
