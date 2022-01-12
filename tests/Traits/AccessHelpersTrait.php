<?php

namespace OlzaLogistic\PpApi\Client\Tests\Traits;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2021 DevelArt IV
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\Util\Validator;

trait AccessHelpersTrait
{
    /**
     * Calls protected method of $object, passing optional array of arguments.
     *
     * @param object|string $objectOrClass Object to call $method_name on or name of the class.
     * @param string        $methodName    Name of method to called.
     * @param array         $args          Optional array of arguments (empty array if no args to pass).
     *
     * @return mixed
     *
     * @throws \ReflectionException
     * @throws \RuntimeException
     */
    protected function callProtectedMethod($objectOrClass, string $methodName, array $args = [])
    {
        Validator::assertIsObjectOrExistingClass('objectOrClass', $objectOrClass);

        /**
         * At this point $objectOrClass is either object or string but some static analyzers
         * got problems figuring that out, so this (partially correct) var declaration is
         * to make them believe.
         *
         * @var object $objectOrClass
         */
        $reflection = new \ReflectionClass($objectOrClass);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs(\is_object($objectOrClass) ? $objectOrClass : null, $args);
    }

    /**
     * Returns value of otherwise non-public member of the class
     *
     * @param string|object $objectOrClass class name to get member from, or instance of that class
     * @param string        $name          member name to grab (i.e. `max_length`)
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    protected function getProtectedMember($objectOrClass, string $name)
    {
        Validator::assertIsObjectOrExistingClass('objectOrClass', $objectOrClass);

        /**
         * At this point $obj_or_cls is either object or string but some static analyzers
         * got problems figuring that out, so this (partially correct) var declaration is
         * to make them believe.
         *
         * @var object $objectOrClass
         */
        $reflection = new \ReflectionClass($objectOrClass);
        $property = $reflection->getProperty($name);
        $property->setAccessible(true);

        return $property->getValue(is_object($objectOrClass) ? $objectOrClass : null);
    }

    /**
     * Returns value of otherwise non-public member of the class
     *
     * @param string|object $objectOrClass class name to get member from, or instance of that class
     * @param string        $name          name of constant to grab (i.e. `FOO`)
     *
     * @return mixed
     */
    protected function getProtectedConstant($objectOrClass, string $name)
    {
        Validator::assertIsObjectOrExistingClass('objectOrClass', $objectOrClass);

        /**
         * At this point $obj_or_cls is either object or string but some static analyzers
         * got problems figuring that out, so this (partially correct) var declaration is
         * to make them believe.
         *
         * @var object $objectOrClass
         */
        return (new \ReflectionClass($objectOrClass))->getConstant($name);
    }

} // end of class

