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

use OlzaLogistic\PpApi\Client\Contracts\ArrayableContract;

/**
 * Immutable object representing elements of "data" node of the API response.
 */
class Data extends \ArrayObject implements ArrayableContract
{
    public function toArray(): array
    {
        $result = [];
        foreach($this as $key => $value) {
            if ($value instanceof ArrayableContract) {
                $value = $value->toArray();
            } else if ($value instanceof \Stringable) {
                $value = $value->__toString();
            } else if ($value instanceof \ArrayObject) {
                $value = $value->getArrayCopy();
            } else if (is_object($value)) {
                $cls = \get_class($value);
                $value = "<{$cls}>";
            }
            $result[$key] = $value;
        }
        return $result;
    }

}
