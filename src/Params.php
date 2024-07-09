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

namespace OlzaLogistic\PpApi\Client;


use OlzaLogistic\PpApi\Client\Util\Json;

/**
 * Represents set of QUERY parameters to be used with API calls.
 */
class Params extends QueryParams
{
    /**
     * C'tor. No direct instantiation allowed though
     */
    protected function __construct()
    {
        $this->postParams = new PostParams();
    }

    /**
     * Returns new instance of Params
     */
    public static function create(): self
    {
        return new self();
    }

    /* ****************************************************************************************** */

    /**
     * Returns QueryParams instance
     */
    public function getQueryParams(): QueryParams
    {
        return $this;
    }

    /* ****************************************************************************************** */

    /** @var PostParams */
    protected $postParams;

    /**
     * Returns PostParams instance
     */
    public function getPostParams(): PostParams
    {
        return $this->postParams;
    }

    /**
     * Sets JSON POST payload data to be sent with API request.
     *
     * @param array $payload JSON data to set.
     *
     * @return static
     * @throws \JsonException on JSON encoding error
     */
    public function withPostPayload(array $payload)
    {
        $json = Json::encode($payload);
        $this->postParams->setJson($json);
        return $this;
    }

    /* ****************************************************************************************** */

} // end of class
