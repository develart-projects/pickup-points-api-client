<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2023-2024 DevelArt
 * @license   Proprietary
 */

namespace OlzaLogistic\PpApi\Client\Exception;

use OlzaLogistic\PpApi\Client\ApiCode;

/**
 * Thrown when API call fails due to access denied (like invalid API token)
 */
class AccessDeniedException extends MethodFailedException
{
    public function __construct(?string    $reason = null,
                                int        $code = ApiCode::ERROR_ACCESS_DENIED,
                                \Throwable $previous = null)
    {
        $reason = $reason ?? 'Access denied';
        parent::__construct($reason, $code, $previous);
    }

} // end of class
