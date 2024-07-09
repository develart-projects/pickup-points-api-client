<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client;


use OlzaLogistic\PpApi\Client\Util\Validator;

/**
 * Represents set of POST parameters to be used with API calls.
 */
class PostParams
{
    public const KEY_LANGUAGE = 'language';
    public const KEY_NAME     = 'name';

    /* ****************************************************************************************** */

    /** @var string */
    protected $json;

    /** @var bool */
    protected $jsonSet = false;

    /**
     * Sets JSON POST payload data to be sent with API request.
     *
     * @param string $json JSON data to set.
     *
     * @throws \InvalidArgumentException If JSON data is not valid JSON string.
     */
    public function setJson(string $json): void
    {
        Validator::assertIsJson('json', $json);

        $this->json = $json;
        $this->jsonSet = true;
    }

    /**
     * Returns string encoded JSON POST payload data to be sent with API request.
     *
     * @return string String encoded JSON data.
     *
     * @throws \LogicException If JSON value was not set.
     */
    public function getJson(): string
    {
        if (!$this->jsonSet) {
            throw new \LogicException('JSON value not set');
        }
        return $this->json;
    }

    /**
     * Returns TRUE if JSON value was set and it's safe to call getJson().
     */
    public function hasJson(): bool
    {
        return $this->jsonSet;
    }

} // end of class
