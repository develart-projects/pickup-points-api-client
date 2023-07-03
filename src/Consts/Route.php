<?php
declare(strict_types=1);

/**
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Consts;

class Route
{
    /**
     * @var string
     */
    protected const PREFIX = '/v1/pp';

    /* ****************************************************************************************** */

    /**
     * @var string
     */
    public const FIND = self::PREFIX . '/find';

    /**
     * @var string
     */
    public const DETAILS = self::PREFIX . '/details';

    /**
     * @var string
     */
    public const NEARBY = self::PREFIX . '/nearby';

    /**
     * @var string
     */
    public const CONFIG = self::PREFIX . '/config';
}
