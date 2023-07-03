<?php
declare(strict_types=1);

namespace OlzaLogistic\PpApi\Client\Util;

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
 * Data validator helper
 */
class Validator
{
    /**
     *
     * @param string $varName Label or name of the variable to be used in exception message (if thrown).
     * @param mixed  $value   Value to be asserted.
     *
     * @return void'
     */
    public static function assertNotEmpty($varName, $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("Value cannot be empty: {$varName}");
        }
    }

    /**
     * Checks if given $cls_cls_or_obj is either an object or name of existing class.
     *
     * @param string        $varName Label or name of the variable to be used in exception message (if thrown).
     * @param string|object $classOrObject
     *
     * @return void
     */
    public static function assertIsObjectOrExistingClass(string $varName, $classOrObject): void
    {
        $allowedTypes = [
            Type::EXISTING_CLASS,
            Type::OBJECT,
        ];
        static::assertIsType($varName, $classOrObject, $allowedTypes);
    }

    /**
     * Checks if $item (of name $key) is of type that is include in $allowed_types (there's `OR` connection
     * between specified types).
     *
     * @param string $varName      Label or name of the variable to be used in exception message (if thrown).
     * @param mixed  $value        Variable to be asserted.
     * @param array  $allowedTypes Array of allowed types for $value, i.e. [Type::INTEGER]
     */
    public static function assertIsType(string $varName, $value, array $allowedTypes): void
    {
        // Type::EXISTING_CLASS is artificial type, so we need separate logic to handle it.
        $tmp = $allowedTypes;
        $idx = array_search(Type::EXISTING_CLASS, $tmp, true);
        if ($idx !== false) {
            // Remove the type, so gettype() test loop won't see it.
            unset($tmp[ $idx ]);
            if (is_string($value) && class_exists($value)) {
                // It's existing class, no need to test further.
                return;
            }
        }

        if (!empty($tmp)) {
            $type = \gettype($value);
            if (!\in_array($type, $allowedTypes, true)) {
                throw static::buildException($varName, $type, $allowedTypes);
            }
        } else {
            throw new \RuntimeException("Class not found");
        }
    }

    /**
     * @param string $varName      Name of the variable (to be included in error message)
     * @param array  $allowedTypes Array of allowed types [Type::*]
     * @param string $type         Current type of the $value
     *
     * @throws \RuntimeException
     */
    protected static function buildException(string $varName, string $type,
                                             array  $allowedTypes): \RuntimeException
    {
        switch (\count($allowedTypes)) {
            case 0:
                throw new \RuntimeException('allowedTypes array must not be empty.');

            case 1:
                $msg = '"%s" must be %s but %s found.';
                break;

            default;
                $msg = '"%s" must be one of allowed types: %s but %s found.';
                break;
        }

        $exMsg = \sprintf($msg, $varName, \implode(', ', $allowedTypes), $type);

        return new \RuntimeException($exMsg);
    }

    /**
     * Ensures $obj (that is value coming from variable, which name is passed in $label) is instance of $cls class.
     *
     * @param string $varName Name of variable that the $obj value is coming from. Used for exception message.
     * @param object $obj     Object to check instance of
     * @param string $cls     Target class we want to check $obj agains.
     *
     * @throws \InvalidArgumentException
     */
    public static function assertInstanceOf(string $varName, object $obj, string $cls): void
    {
        if (!($obj instanceof $cls)) {
            throw new \InvalidArgumentException(
                \sprintf('"%s" must be instance of "%s".', $varName, $cls)
            );
        }
    }

    /**
     * Ensures provided $value is in specified $range.
     *
     * @param string    $varName Name of variable that the $obj value is coming from. Used for exception message reference.
     * @param float|int $value   Current value of the variable.
     * @param float|int $min     Minimum allowed value (inclusive).
     * @param float|int $max     Maximum allowed value (inclusive).
     *
     * @throws \InvalidArgumentException
     */
    public static function assertIsInRange(string $varName, $value, $min, $max): void
    {
        static::assertIsNumber($varName, $value);
        static::assertIsNumber($varName, $min);
        static::assertIsNumber($varName, $max);

        if ($value < $min || $value > $max) {
            $msg = \sprintf('"%s" must be in range [%s, %s]: %s', $varName, $min, $max, $value);
            throw new \InvalidArgumentException($msg);
        }
    }

    /**
     * Ensures provided value is a number (either int or float).
     *
     * @param string $varName Name of variable that the $obj value is coming from. Used for exception message reference.
     * @param mixed  $value
     */
    public static function assertIsNumber(string $varName, $value): void
    {
        if (!(\is_int($value) || \is_float($value))) {
            $msg = \sprintf('"%s" must be a number: "%s" given.', $varName, \gettype($value));
            throw new \InvalidArgumentException($msg);
        }
    }

} // end of class
