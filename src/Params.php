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

    public function getQueryParams(): QueryParams
    {
        return $this;
    }

    /* ****************************************************************************************** */

    /** @var PostParams */
    protected $postParams;

    public function getPostParams(): PostParams
    {
        return $this->postParams;
    }

    public function withPostPayload(array $payload): self
    {
        $json = Json::encode($payload);
        $this->postParams->setJson($json);
        return $this;
    }

} // end of class
