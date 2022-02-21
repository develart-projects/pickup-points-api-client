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
class MethodFailedException extends \RuntimeException
{
    public function __construct(?string $reason = null, int $code = 0, \Throwable $previous = null)
    {
        $reason ??= "API method failed";
        parent::__construct($reason, $code, $previous);
    }

} // end of class
