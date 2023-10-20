<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client;

use OlzaLogistic\PpApi\Client\Model\Spedition;

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
     * Adds single configuration item to the list.
     *
     * @param string $key   Configuration item key
     * @param mixed  $value Configuration item value
     */
    public function addConfigItem(string $key, $value): self
    {
        $this->config[$key] = $value;
        return $this;
    }

    /**
     * Adds multiple configuration items to the list.
     *
     * @param array<string,mixed> $items Associative array of configuration items
     */
    public function addConfigItems(array $items): self
    {
        foreach ($items as $key => $value) {
            $this->addConfigItem($key, $value);
        }
        return $this;
    }

    /* ****************************************************************************************** */

    protected array $speditions = [];

    /**
     * Returns list of Spedition objects.
     *
     * @return Spedition[]
     */
    public function getSpeditions(): array
    {
        return $this->speditions;
    }

    /**
     * Adds Spedition object to the list.
     *
     * @param Spedition $spedition Spedition object to add
     */
    public function addSpedition(Spedition $spedition): self
    {
        $this->speditions[$spedition->getCode()] = $spedition;
        return $this;
    }

    /* ****************************************************************************************** */

    public function toArray(): array
    {
        $result = [];
        foreach ($this->config as $key => $value) {
            $result['config'][$key] = $value;
        }
        foreach ($this->speditions as $key => $value) {
            $result['speditions'][$key] = $value->toArray();
        }

        return $result;
    }

} // end of class
