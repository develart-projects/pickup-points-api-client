<?php

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Tests;

abstract class BaseTestCase extends \PHPUnit\Framework\TestCase
{
    use Traits\TestHelpersTrait;
    use Traits\AccessHelpersTrait;
    use \MarcinOrlowski\PhpunitExtraAsserts\Traits\ExtraAsserts;
} // end of class
