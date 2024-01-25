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

/**
 * Thrown on attempt to modify sealed client instance.
 */
class ClientAlreadyInitializedException extends \LogicException
{
    public function __construct()
    {
        parent::__construct('Client already initialized');
    }

} // end of class
