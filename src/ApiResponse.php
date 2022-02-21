<?php

namespace OlzaLogistic\PpApi\Client;

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
class ApiResponse
{
    /**
     * JSON key for API response structure for "success" status.
     *
     * @var string
     */
    public const KEY_SUCCESS = 'success';

    /**
     * JSON key for API response structure for "code" value.
     *
     * @var string
     */
    public const KEY_CODE = 'code';

    /**
     * JSON key for API response structure for "message" status.
     *
     * @var string
     */
    public const KEY_MESSAGE = 'message';

    /**
     * JSON key for API response structure for "data" node.
     *
     * @var string
     */
    public const KEY_DATA = 'data';

    /* ****************************************************************************************** */

    /**
     * JSON key for API for list of items.
     *
     * @var string
     */
    public const KEY_ITEMS = 'items';

    /**
     * JSON key for API for list of configuration items.
     *
     * @var string
     */
    public const KEY_CONFIG = 'config';

    /**
     * @var string
     */
    public const KEY_SPEDITIONS = 'speditions';

    /**
     * @var string
     */
    public const KEY_LABEL = 'label';

} // end of class
