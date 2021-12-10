<?php

namespace OlzaLogistic\PpApi\Client;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2021 DevelArt IV
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\Model\PickupPoint;
use Psr\Http\Message\ResponseInterface;

/**
 * Immutable object representing API action response.
 */
class Result
{
    /**
     * Returns instance of Result preconfigured to indicate success.
     *
     * @param array|null $data Optional data to be added as result payload. Can also
     *                         be added later using setData() method.
     */
    public static function asSuccess(?array $data = null): self
    {
        $result = new self(true);
        $result->setData($data);

        return $result;
    }

    /**
     * Returns instance of Result preconfigured to indicate failure.
     */
    public static function asError(): self
    {
        return new self(false);
    }

    /**
     * Returns instance of Result preconfigured to indicate failure based on provided
     * Throwable object.
     */
    public static function fromThrowable(\Throwable $ex): self
    {
        return (static::asError())
            ->setMessage($ex->getMessage())
            ->setCode($ex->getCode());
    }

    /**
     * Returns instance of Result filled with data from provided API response.
     * NOTE: only results with
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return static
     */
    public static function fromApiResponse(ResponseInterface $response): self
    {
        if ($response->getStatusCode() !== 200) {
            $code = $response->getStatusCode();
            $reason = $response->getReasonPhrase();
            if ($reason === '') {
                $reason = "HTTP error #{$code}";
            }
            return (static::asError())
                ->setCode($code)
                ->setMessage($reason);
        }

        try {
            $json = \json_decode($response->getBody()->getContents(), true, 32, \JSON_THROW_ON_ERROR);
            if (!static::isApiResponseArrayValid($json)) {
                return static::asError();
            }
            $result = $json[ Consts::API_KEY_SUCCESS ] ? self::asSuccess() : self::asError();
            $result
                ->setCode($json[ Consts::API_KEY_CODE ])
                ->setMessage($json[ Consts::API_KEY_MESSAGE ]);

            $data = null;

            if ($json[ Consts::API_KEY_DATA ] !== null) {
                $dataSrc = $json[ Consts::API_KEY_DATA ][ Consts::API_KEY_ITEMS ];
                $data = [];
                foreach ($dataSrc as $item) {
                    $data[] = PickupPoint::fromApiResponse($item);
                }
            }
            $result->setData($data);
        } catch (\Throwable $ex) {
            $result = (static::asError())
                ->setMessage($ex->getMessage());
        }

        return $result;
    }

    /** ********************************************************************************************* **/

    /**
     * Ensures decoded JSON response from API matches expectations.
     *
     * @param array $json Decoded API response array.
     *
     * @return bool
     */

    protected static function isApiResponseArrayValid(array $json): bool
    {
        $requiredKeys = [
            Consts::API_KEY_SUCCESS,
            Consts::API_KEY_MESSAGE,
            Consts::API_KEY_CODE,
            Consts::API_KEY_DATA,
        ];

        foreach ($requiredKeys as $key) {
            if (!\array_key_exists($key, $json)) {
                return false;
            }
        }

        if (!\is_bool($json[ Consts::API_KEY_SUCCESS ])
            || !\is_string($json[ Consts::API_KEY_MESSAGE ])
            || !\is_int($json[ Consts::API_KEY_CODE ])
            || !($json[ Consts::API_KEY_DATA ] === null
                || \is_array($json[ Consts::API_KEY_DATA ]))
        ) {
            return false;
        }

        return true;
    }

    /** ********************************************************************************************* **/

    protected function __construct(bool $success)
    {
        $this->setSuccess($success);
    }

    /** ********************************************************************************************* **/

    /**
     * Set to TRUE if result relates to successful action's response, FALSE otherwise.
     */
    protected bool $success = false;

    public function success(): bool
    {
        return $this->success;
    }

    protected function setSuccess(bool $success): self
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @var int $code API code associated with the response.
     */
    protected int $code = 0;

    public function getCode(): int
    {
        return $this->code;
    }

    protected function setCode(int $apiCode): self
    {
        $this->code = $apiCode;
        return $this;
    }

    protected ?string $message = null;

    public function getMessage(): ?string
    {
        return $this->message;
    }

    protected function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    protected ?array $data = null;

    public function getData(): ?array
    {
        return $this->data;
    }

    protected function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

} // end of class
