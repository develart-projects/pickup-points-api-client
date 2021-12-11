<?php

namespace OlzaLogistic\PpApi\Client\Consts;

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
class Route
{
    /**
     * @var string
     */
    protected const PREFIX = '/v1/pp';

    /**
     * @var string
     */
    public const FIND = self::PREFIX . '/find';

    /**
     * @var string
     */
    public const DETAILS = self::PREFIX . '/details';
}
