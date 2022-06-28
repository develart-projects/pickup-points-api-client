<?php
declare(strict_types=1);

namespace OlzaLogistic\PpApi\Client;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

/**
 * Definition of elements supported by "payments" query argument
 */
class PaymentType
{

    public const CASH = 'cash';
    public const CARD = 'card';

} // end of class
