<?php

namespace OlzaLogistic\PpApi\Client;

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

/**
 * Immutable object representing elements of "data" node of the API response.
 */
class Data extends \ArrayObject
{
    protected ?array $items = null;

    public function addItem($value): self
    {
        if ($this->items === null) {
            $this->items = [];
        }
        $this->items[] = $value;
        return $this;
    }

    public function setItems(?array $items): self
    {
        $this->items = $items;
        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

} // end of class
