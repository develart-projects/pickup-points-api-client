<?php

namespace OlzaLogistic\PpApi\Client;

use OlzaLogistic\PpApi\Client\Model\Spedition;

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

/**
 * Immutable object representing elements of "configuration data" node of the API response.
 */
class ConfigData extends Data
{
    protected array $config = [];

    public function getConfigItems(): array
    {
        return $this->config;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function addConfigItem(string $key, $value): self
    {
        $this->config[ $key ] = $value;
        return $this;
    }

    public function addConfigItems(array $items): self
    {
        foreach ($items as $key => $value) {
            $this->addConfigItem($key, $value);
        }
        return $this;
    }

    /* ****************************************************************************************** */

    protected array $speditions = [];

    public function getSpeditions(): array
    {
        return $this->speditions;
    }

    /**
     * @param Spedition $spedition
     *
     * @return $this
     */
    public function addSpedition(Spedition $spedition): self
    {
        $this->speditions[ $spedition->getCode() ] = $spedition;
        return $this;
    }

    /* ****************************************************************************************** */

} // end of class
