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

namespace OlzaLogistic\PpApi\Client;

/**
 * Definition of elements of Pickup Point of data to be returned by the API end points.
 */
class FieldType
{
    /**
     * Include array of Pickup Point name strings
     *
     * @var string
     */
    public const NAME = 'name';

    /**
     * Include street address node.
     *
     * @var string
     */

    public const ADDRESS = 'address';

    /**
     * Include contact (email, phone etc) details.
     *
     * @var string
     */
    public const CONTACTS = 'contacts';

    /**
     * Include opening hours node.
     *
     * @var string
     */
    public const HOURS = 'hours';

    /**
     * Include GPS location node.
     *
     * @var string
     */
    public const LOCATION = 'location';

} // end of class
