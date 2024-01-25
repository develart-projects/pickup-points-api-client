<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client;

/**
 * Definition of elements supported by "payments" query argument
 */
class PaymentType
{
    /**
     * Cash payment
     *
     * @var string
     */
    public const CASH = 'cash';

    /**
     * Card payment
     *
     * @var string
     */
    public const CARD = 'card';

} // end of class
