<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2022-2024 DevelArt
 * @license   Proprietary
 */

namespace OlzaLogistic\PpApi\Client\Exception;

class InvalidResponseStructureException extends \RuntimeException
{
    public function __construct(?string $msg = null, int $code = 0, \Throwable $previous = null)
    {
        $msg = $msg ?? "Invalid response data structure.";
        parent::__construct($msg, $code, $previous);
    }

} // end of class
