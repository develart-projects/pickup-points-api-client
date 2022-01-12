<?php

namespace OlzaLogistic\PpApi\Client\Tests;

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
abstract class BaseTestCase extends \PHPUnit\Framework\TestCase
{
    use Traits\TestHelpersTrait;
    use Traits\AccessHelpersTrait;
    use \MarcinOrlowski\PhpunitExtraAsserts\Traits\ExtraAsserts;
} // end of class
