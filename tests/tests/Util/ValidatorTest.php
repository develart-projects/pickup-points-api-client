<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Jozef Liška <jozef.liska (#) develart (.) cz>
 * @copyright 2026 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests\Util;

use OlzaLogistic\PpApi\Client\Tests\BaseTestCase;
use OlzaLogistic\PpApi\Client\Util\Type;
use OlzaLogistic\PpApi\Client\Util\Validator;

class ValidatorTest extends BaseTestCase
{
    /* ****************************************************************************************** */
    /* assertNotEmpty */
    /* ****************************************************************************************** */

    public function testAssertNotEmptyWithValidValue(): void
    {
        $this->expectNotToPerformAssertions();
        
        $varName = $this->getRandomString('var');
        $value = $this->getRandomString('value');
        
        Validator::assertNotEmpty($varName, $value);
    }

    public function testAssertNotEmptyWithEmptyString(): void
    {
        $varName = $this->getRandomString('var');
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Value cannot be empty: {$varName}");
        
        Validator::assertNotEmpty($varName, '');
    }

    public function testAssertNotEmptyWithNull(): void
    {
        $varName = $this->getRandomString('var');
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Value cannot be empty: {$varName}");
        
        Validator::assertNotEmpty($varName, null);
    }

    public function testAssertNotEmptyWithZero(): void
    {
        $varName = $this->getRandomString('var');
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Value cannot be empty: {$varName}");
        
        Validator::assertNotEmpty($varName, 0);
    }

    /* ****************************************************************************************** */
    /* assertIsObjectOrExistingClass */
    /* ****************************************************************************************** */

    public function testAssertIsObjectOrExistingClassWithObject(): void
    {
        $this->expectNotToPerformAssertions();
        
        $varName = $this->getRandomString('var');
        $object = new \stdClass();
        
        Validator::assertIsObjectOrExistingClass($varName, $object);
    }

    public function testAssertIsObjectOrExistingClassWithClassName(): void
    {
        $this->expectNotToPerformAssertions();
        
        $varName = $this->getRandomString('var');
        
        Validator::assertIsObjectOrExistingClass($varName, \stdClass::class);
    }

    public function testAssertIsObjectOrExistingClassWithNonExistingClass(): void
    {
        $varName = $this->getRandomString('var');
        $className = $this->getRandomString('NonExistingClass');
        
        $this->expectException(\RuntimeException::class);
        
        Validator::assertIsObjectOrExistingClass($varName, $className);
    }

    public function testAssertIsObjectOrExistingClassWithInvalidType(): void
    {
        $varName = $this->getRandomString('var');
        $value = $this->getRandomInt();
        
        $this->expectException(\RuntimeException::class);
        
        Validator::assertIsObjectOrExistingClass($varName, $value);
    }

    /* ****************************************************************************************** */
    /* assertIsType */
    /* ****************************************************************************************** */

    /**
     * @dataProvider validTypeProvider
     * @param mixed $value
     */
    public function testAssertIsTypeWithValidType($value, array $allowedTypes): void
    {
        $this->expectNotToPerformAssertions();
        
        $varName = $this->getRandomString('var');
        
        Validator::assertIsType($varName, $value, $allowedTypes);
    }

    public static function validTypeProvider(): array
    {
        return [
            'string' => ['test_value', [Type::STRING]],
            'integer' => [123, [Type::INTEGER]],
            'boolean' => [true, [Type::BOOLEAN]],
            'array' => [['key' => 'value'], [Type::ARRAY]],
            'object' => [new \stdClass(), [Type::OBJECT]],
            'double' => [1.23, [Type::DOUBLE]],
            'null' => [null, [Type::NULL]],
            'existing class' => [\stdClass::class, [Type::EXISTING_CLASS]],
            'multiple types' => ['test_value', [Type::STRING, Type::INTEGER]],
        ];
    }

    public function testAssertIsTypeWithInvalidType(): void
    {
        $varName = $this->getRandomString('var');
        $value = $this->getRandomString('value');
        
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('/".*" must be .* but .* found\./');
        
        Validator::assertIsType($varName, $value, [Type::INTEGER]);
    }

    public function testAssertIsTypeWithEmptyAllowedTypes(): void
    {
        $varName = $this->getRandomString('var');
        $value = $this->getRandomString('value');
        
        $this->expectException(\RuntimeException::class);
        
        Validator::assertIsType($varName, $value, []);
    }

    /* ****************************************************************************************** */
    /* assertInstanceOf */
    /* ****************************************************************************************** */

    public function testAssertInstanceOfWithValidInstance(): void
    {
        $this->expectNotToPerformAssertions();
        
        $varName = $this->getRandomString('var');
        $obj = new \stdClass();
        
        Validator::assertInstanceOf($varName, $obj, \stdClass::class);
    }

    public function testAssertInstanceOfWithInvalidInstance(): void
    {
        $varName = $this->getRandomString('var');
        $obj = new \stdClass();
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/".*" must be instance of ".*"\./');
        
        Validator::assertInstanceOf($varName, $obj, \Exception::class);
    }

    /* ****************************************************************************************** */
    /* assertIsInRange */
    /* ****************************************************************************************** */

    /**
     * @dataProvider validRangeProvider
     * @param int|float $value
     * @param int|float $min
     * @param int|float $max
     */
    public function testAssertIsInRangeWithValidValue($value, $min, $max): void
    {
        $this->expectNotToPerformAssertions();
        
        $varName = $this->getRandomString('var');
        
        Validator::assertIsInRange($varName, $value, $min, $max);
    }

    public static function validRangeProvider(): array
    {
        return [
            'integer in range' => [5, 1, 10],
            'float in range' => [5.5, 1.0, 10.0],
            'min boundary' => [1, 1, 10],
            'max boundary' => [10, 1, 10],
        ];
    }

    public function testAssertIsInRangeWithValueBelowMin(): void
    {
        $varName = $this->getRandomString('var');
        $value = 0;
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/".*" must be in range \[.*, .*\]: .*/');
        
        Validator::assertIsInRange($varName, $value, 1, 10);
    }

    public function testAssertIsInRangeWithValueAboveMax(): void
    {
        $varName = $this->getRandomString('var');
        $value = 11;
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/".*" must be in range \[.*, .*\]: .*/');
        
        Validator::assertIsInRange($varName, $value, 1, 10);
    }

    public function testAssertIsInRangeWithNonNumericValue(): void
    {
        $varName = $this->getRandomString('var');
        $value = $this->getRandomString('not_a_number');
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/".*" must be a number: ".*" given\./');
        
        Validator::assertIsInRange($varName, $value, 1, 10);
    }

    /* ****************************************************************************************** */
    /* assertIsNumber */
    /* ****************************************************************************************** */

    /**
     * @dataProvider validNumberProvider
     * @param int|float $value
     */
    public function testAssertIsNumberWithValidNumber($value): void
    {
        $this->expectNotToPerformAssertions();
        
        $varName = $this->getRandomString('var');
        
        Validator::assertIsNumber($varName, $value);
    }

    public static function validNumberProvider(): array
    {
        return [
            'integer' => [123],
            'float' => [1.23],
        ];
    }

    public function testAssertIsNumberWithString(): void
    {
        $varName = $this->getRandomString('var');
        $value = $this->getRandomString('not_a_number');
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/".*" must be a number: ".*" given\./');
        
        Validator::assertIsNumber($varName, $value);
    }

    public function testAssertIsNumberWithNull(): void
    {
        $varName = $this->getRandomString('var');
        $value = null;
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/".*" must be a number: ".*" given\./');
        
        Validator::assertIsNumber($varName, $value);
    }

    /* ****************************************************************************************** */
    /* assertIsJson */
    /* ****************************************************************************************** */

    public function testAssertIsJsonWithValidJson(): void
    {
        $this->expectNotToPerformAssertions();
        
        $varName = $this->getRandomString('var');
        $data = [
            $this->getRandomString('key1') => $this->getRandomString('value1'),
            $this->getRandomString('key2') => $this->getRandomInt(),
        ];
        $value = (string)json_encode($data);
        
        Validator::assertIsJson($varName, $value);
    }

    public function testAssertIsJsonWithInvalidJson(): void
    {
        $varName = $this->getRandomString('var');
        $value = '{invalid json}';
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid JSON string: {$varName}");
        
        Validator::assertIsJson($varName, $value);
    }

    public function testAssertIsJsonWithEmptyString(): void
    {
        $varName = $this->getRandomString('var');
        $value = '';
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid JSON string: {$varName}");
        
        Validator::assertIsJson($varName, $value);
    }

} // end of class
