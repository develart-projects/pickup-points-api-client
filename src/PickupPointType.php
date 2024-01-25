<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client;

/**
 * Pickup Point types
 */
class PickupPointType
{
    /** Parcel Terminal, parcel locker */
    public const LOCKER = 'locker';

    /** Post office */
    public const POST = 'post';

    /** Point (pickup point, parcel shop, branch) */
    public const POINT = 'point';

    /* ****************************************************************************************** */

    public const ALL_TYPES = [
        self::LOCKER,
        self::POINT,
        self::POST,
    ];

} // end of class
