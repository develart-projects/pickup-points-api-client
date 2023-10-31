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

use OlzaLogistic\PpApi\Client\ApiCode;

/**
 * Thrown when API call fails due to requested object not found.
 */
class ObjectNotFoundException extends MethodFailedException
{
    public function __construct(?string    $reason = null,
                                int        $code = ApiCode::ERROR_OBJECT_NOT_FOUND,
                                \Throwable $previous = null)
    {
        $reason = $reason ?? 'Object not found';
        parent::__construct($reason, $code, $previous);
    }

} // end of class
