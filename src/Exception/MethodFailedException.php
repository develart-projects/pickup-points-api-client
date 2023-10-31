<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022-2023 DevelArt
 * @license   Proprietary
 */

namespace OlzaLogistic\PpApi\Client\Exception;

class MethodFailedException extends \RuntimeException
{
    public function __construct(?string $reason = null, int $code = 0, \Throwable $previous = null)
    {
        $reason = $reason ?? 'API method failed';
        parent::__construct($reason, $code, $previous);
    }

} // end of class
