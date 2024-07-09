<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Util;

class Lockpick
{
    /**
     * Calls protected method of $object, passing optional array of arguments.
     *
     * @param object|string $clsOrObj   Object to call $methodName on or name of the class.
     * @param string        $methodName Name of method to call.
     * @param array         $args       Optional array of arguments (empty array for no args).
     *
     * @return mixed
     *
     * @throws \ReflectionException
     * @throws \RuntimeException
     */
    public static function call($clsOrObj, string $methodName, array $args = [])
    {
        static::assertClassOrString($clsOrObj);

        /**
         * At this point $objectOrClass is either object or string but some static analyzers
         * got problems figuring that out, so this (partially correct) var declaration is
         * to make them believe.
         *
         * @phpstan-ignore-next-line
         */
        $reflection = new \ReflectionClass($clsOrObj);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs(\is_object($clsOrObj) ? $clsOrObj : null, $args);
    }

    /**
     * Sets protected property
     *
     * @param object|string $clsOrObj Object to call $methodName on or name of the class.
     * @param string        $name     Property name to set.
     * @param mixed         $value    Value to set.
     *
     * @return void
     * @throws \ReflectionException
     */
    public static function setProperty($clsOrObj, string $name, $value): void
    {
        static::assertClassOrString($clsOrObj);

        /**
         * At this point $objectOrClass is either object or string but some static analyzers
         * got problems figuring that out, so this (partially correct) var declaration is
         * to make them believe.
         */
        /** @var mixed $clsOrObj */
        $reflection = new \ReflectionClass($clsOrObj);
        $property = $reflection->getProperty($name);
        $property->setAccessible(true);
        /** @var mixed $clsOrObj */
        $property->setValue($clsOrObj, $value);
    }

    /**
     * Ebsures argument is of expected type.
     *
     * @param mixed $clsOrObj Object or class name to check.
     *
     * @throws \RuntimeException If argument is not object or string.
     */
    protected static function assertClassOrString($clsOrObj): void
    {
        if (\is_object($clsOrObj) === false && \is_string($clsOrObj) === false) {
            throw new \RuntimeException('Invalid argument type');
        }
    }

} // end of Location
