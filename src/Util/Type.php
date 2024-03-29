<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Util;

/**
 * Data type constants
 */
final class Type
{
    /** @var string */
    public const STRING = 'string';

    /** @var string */
    public const INTEGER = 'integer';

    /** @var string */
    public const BOOLEAN = 'boolean';

    /** @var string */
    public const ARRAY   = 'array';

    /** @var string */
    public const OBJECT = 'object';

    /** @var string */
    public const DOUBLE = 'double';

    /** @var string */
    public const NULL = 'NULL';

    /** @var string */
    public const EXISTING_CLASS = 'existing class';
}
