<?php
declare(strict_types=1);

namespace OlzaLogistic\PpApi\Client\Exception;

/**
 * Olza Logistic's Pickup Points API (server)
 *
 * @package   OlzaLogistic\PpApi\Server
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022 DevelArt
 * @license   Proprietary
 */

class ResponseParsingException extends \RuntimeException
{
    public function __construct(?string $msg = null, int $code = 0, \Throwable $previous = null)
    {
        $msg ??= "Failed parsing API response.";
        parent::__construct($msg, $code, $previous);
    }

} // end of class
