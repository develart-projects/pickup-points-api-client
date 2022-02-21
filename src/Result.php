<?php
declare(strict_types=1);

namespace OlzaLogistic\PpApi\Client;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\Exception\ResponseIncorrectParserException;
use OlzaLogistic\PpApi\Client\Model\PickupPoint;
use OlzaLogistic\PpApi\Client\Model\Spedition;
use Psr\Http\Message\ResponseInterface;

/**
 * Immutable object representing API action response.
 */
class Result
{
    /**
     * Returns instance of Result preconfigured to indicate success.
     *
     * @param Data|null $data Optional data to be added as result payload. Can also
     *                        be added later using setData() method.
     */
    public static function asSuccess(?Data $data = null): self
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

    protected static function getConfiguredResponseObject(ResponseInterface $response,
                                                          array             $extraKeys): self
    {
        $code = $response->getStatusCode();
        $body = $response->getBody();
        $body->rewind();
        $jsonStr = $body->getContents();

        /** @var array $json */
        $json = \json_decode($jsonStr, true, 32, \JSON_THROW_ON_ERROR);
        if (!static::isApiResponseArrayValid($json, $extraKeys)) {
            throw new ResponseIncorrectParserException();
        }

        /** @var string $message */
        $message = $json[ ApiResponse::KEY_MESSAGE ];
        if ($message === '') {
            $message = "HTTP error #{$code}";
        }

        $result = $json[ ApiResponse::KEY_SUCCESS ] ? self::asSuccess() : self::asError();
        $result
            ->setCode($json[ ApiResponse::KEY_CODE ])
            ->setMessage($message);

        return $result;
    }

    /**
     * Returns instance of Result filled with data from provided API response with "items"
     * elements in Data node.
     *
     * NOTE: only results with with single "items" list in "data" node.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \RuntimeException
     */
    public static function fromApiResponseWithItems(ResponseInterface $response): self
    {
        try {
            $body = $response->getBody();
            $body->rewind();
            $respJsonStr = $body->getContents();
            /** @var array $json */
            $json = \json_decode($respJsonStr, true, 32, \JSON_THROW_ON_ERROR);

            $requiredKeys = [
                ApiResponse::KEY_ITEMS,
            ];
            $result = static::getConfiguredResponseObject($response, $requiredKeys);

            $data = null;
            if ($json[ ApiResponse::KEY_DATA ] !== null) {
                $dataSrc = $json[ ApiResponse::KEY_DATA ][ ApiResponse::KEY_ITEMS ];
                $data = new Data();
                foreach ($dataSrc as $item) {
                    $data[] = PickupPoint::fromApiResponse($item);
                }
            }
            $result->setData($data);

        } catch (\Throwable $ex) {
            $result = (static::asError())
                ->setMessage($ex->getMessage());
        }
        /** @var static $result */
        return $result;
    }


    /**
     * Returns instance of Result filled with data from provided config/ API response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public static function fromConfigApiResponse(ResponseInterface $response): self
    {
        try {
            $respJsonStr = $response->getBody()->getContents();
            /** @var array $json */
            $json = \json_decode($respJsonStr, true, 32, \JSON_THROW_ON_ERROR);

            $requiredKeys = [
                ApiResponse::KEY_SPEDITIONS,
            ];
            $result = static::getConfiguredResponseObject($response, $requiredKeys);

            $apiData = $json[ ApiResponse::KEY_DATA ];

            // All speditions found
            $data = new ConfigData();
            foreach ($apiData[ ApiResponse::KEY_SPEDITIONS ] as $speditionData) {
                $spedition = Spedition::fromApiResponse($speditionData);
                $data->addSpedition($spedition);
            }

            // done.
            $result->setData($data);

        } catch (\Throwable $ex) {
            $result = (static::asError())
                ->setMessage($ex->getMessage());
        }
        return $result;
    }

    /* ****************************************************************************************** */

    /**
     * Ensures decoded JSON response from API matches expectations.
     *
     * @param array         $json                 Decoded API response array.
     * @param string[]|null $extraDataKeys        Flat list of keys that must be present as child
     *                                            of "data" node. NOTE: only keys directly in "data"
     *                                            node are checked. Deeper levels are not currently
     *
     * @return bool
     */
    protected static function isApiResponseArrayValid(array  $json,
                                                      ?array $extraDataKeys = null): bool
    {
        // Ensure these elements are present (their keys do exist).
        $requiredKeys = [
            ApiResponse::KEY_CODE,
            ApiResponse::KEY_DATA,
            ApiResponse::KEY_MESSAGE,
            ApiResponse::KEY_SUCCESS,
        ];
        foreach ($requiredKeys as $key) {
            if (!\array_key_exists($key, $json)) {
                return false;
            }
        }

        // Values of these elements must have expected type.
        if (!\is_bool($json[ ApiResponse::KEY_SUCCESS ])
            || !\is_string($json[ ApiResponse::KEY_MESSAGE ])
            || !\is_int($json[ ApiResponse::KEY_CODE ])
        ) {
            return false;
        }

        // if DATA node is provided it must be an array.
        $dataNode = $json[ ApiResponse::KEY_DATA ];
        if ($dataNode !== null && !\is_array($dataNode)) {
            return false;
        }

        // extraDataKeys contains keys that we expect to be present in "data" node
        // but only for successful responses, as otherwise data is usually null.
        if ($json[ApiResponse::KEY_SUCCESS]) {
            $extraDataKeys ??= [];
            if (!empty($extraDataKeys)) {
                // if extra keys are required, "data" node must be present and not empty.
                if ($dataNode === null) {
                    return false;
                }
                foreach ($extraDataKeys as $key) {
                    if (!\array_key_exists($key, $dataNode)) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /* ****************************************************************************************** */

    protected function __construct(bool $success)
    {
        $this->setSuccess($success);
    }

    /* ****************************************************************************************** */

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

    protected string $message = '';

    public function getMessage(): string
    {
        return $this->message;
    }

    protected function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    protected ?Data $data = null;

    public function getData(): ?Data
    {
        return $this->data;
    }

    protected function setData(?Data $data): self
    {
        $this->data = $data;
        return $this;
    }

} // end of class
