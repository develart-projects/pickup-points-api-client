<?php
declare(strict_types=1);

/**
 * Olza Logistic's Pickup Points API (server)
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022-2023 DevelArt
 * @license   Proprietary
 */

namespace OlzaLogistic\PpApi\Client\Exception;

class ResponseParsingException extends \RuntimeException
{
    public function __construct(?string $msg = null, int $code = 0, \Throwable $previous = null)
    {
        $msg ??= "Failed parsing API response.";
        parent::__construct($msg, $code, $previous);
    }

} // end of class
