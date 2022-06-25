<?php

namespace OlzaLogistic\PpApi\Client\Model;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */
class Country
{
    public const BULGARIA = 'bg';
    public const CZECHIA  = 'cz';
    public const GREECE   = 'gr';
    public const HUNGARY  = 'hu';
    public const POLAND   = 'pl';
    public const ROMANIA  = 'ro';
    public const SLOVAKIA = 'sk';

    /** ********************************************************************************************* **/

    /** @var float */
    public const LAT_MIN = -90.0;
    /** @var float */
    public const LAT_MAX = 90.0;
    /** @var float */
    public const LONG_MIN = -180.0;
    /** @var float */
    public const LONG_MAX = 180.0;

} // end of class
