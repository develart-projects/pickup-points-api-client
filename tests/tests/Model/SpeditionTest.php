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

use OlzaLogistic\PpApi\Client\Model\Spedition;
use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;

class SpeditionTest extends BaseTestCase
{
    public function testResponseParsing(): void
    {
        $country = $this->getRandomString('ctry');
        $count = $this->getRandomInt(1, 10);
        foreach ($this->generateSpeditionData($country, $count) as $spedData) {
            /** @var array $spedData */
            $code = $spedData[ Spedition::KEY_CODE ];
            $label = $spedData[ Spedition::KEY_LABEL ];

            $sped = Spedition::fromApiResponse($spedData);

            $this->assertEquals($code, $sped->getCode());
            $this->assertEquals($label, $sped->getLabel());
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
     *
     * @noinspection PhpUnusedParameterInspection
     */
    protected function generateSpeditionData(string $country, int $count): \Generator
    {
        for ($i = 0; $i < $count; $i++) {
            $spedCodeBase = $this->getRandomString('code', 12);

            yield [
                Spedition::KEY_CODE      => "{$spedCodeBase}{$i}",
                Spedition::KEY_LABEL     => $this->getRandomString('label'),
                // TODO: generate fake translations too
                Spedition::KEY_NAMES     => [],
            ];
        }
    }

} // end of class
