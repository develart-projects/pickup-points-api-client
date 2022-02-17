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
    /** @var string */
    public const BULGARIA = 'bg';
    /** @var string */
    public const CZECH_REPUBLIC = 'cz';
    /** @var string */
    public const GREECE = 'gr';
    /** @var string */
    public const HUNGARY = 'hu';
    /** @var string */
    public const POLAND = 'pl';
    /** @var string */
    public const ROMANIA = 'ro';
    /** @var string */
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
