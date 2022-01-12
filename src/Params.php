<?php

namespace OlzaLogistic\PpApi\Client;

/**
 * Olza Logistic's Pickup Points API client
 *
 * @package   OlzaLogistic\PpApi\Client
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2021-2022 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

use OlzaLogistic\PpApi\Client\Util\Validator;

class Params
{
    /** @var string */
    public const ACCESS_TOKEN = 'access_token';

    /** @var string */
    public const SPEDITION = 'spedition';

    /** @var string */
    public const COUNTRY = 'country';

    /** @var string */
    public const CITY = 'city';

    /** @var string */
    public const FIELDS = 'fields';

    /** @var string */
    public const ID = 'id';

    /** @var string */
    public const LOCATION = 'location';

    /* ****************************************************************************************** */

    protected function __construct()
    {
        // dummy
    }

    public static function create(): self
    {
        return new self();
    }

    /* ****************************************************************************************** */

    protected ?string $accessToken = null;

    public function withAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    protected function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /* ****************************************************************************************** */

    protected ?string $country = null;

    public function withCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    protected function getCountry(): ?string
    {
        return $this->country;
    }

    /* ****************************************************************************************** */

    protected ?string $city = null;

    public function withCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    protected function getCity(): ?string
    {
        return $this->city;
    }

    /* ****************************************************************************************** */

    protected ?string $spedition = null;

    public function withSpedition(string $spedition): self
    {
        $this->spedition = $spedition;
        return $this;
    }

    protected function getSpedition(): ?string
    {
        return $this->spedition;
    }

    /* ****************************************************************************************** */

    protected ?string $speditionId = null;

    public function withSpeditionId(string $speditionId): self
    {
        $this->speditionId = $speditionId;
        return $this;
    }

    protected function getSpeditionId(): ?string
    {
        return $this->speditionId;
    }

    /* ****************************************************************************************** */

    protected ?float $latitude  = null;
    protected ?float $longitude = null;

    public function withLocation(?float $latitude, ?float $longitude): self
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        return $this;
    }

    protected function getLatitude(): ?float
    {
        return $this->latitude;
    }

    protected function getLongitude(): ?float
    {
        return $this->longitude;
    }

    protected function getLocationAsString(): ?string
    {
        if ($this->latitude === null || $this->longitude === null) {
            return null;
        }
        return sprintf('%f,%f', $this->latitude, $this->longitude);
    }

    /* ****************************************************************************************** */

    protected array $fields = [];

    public function withFields(?array $fields): self
    {
        $fields = $fields ?? [];
        $this->fields = $fields;
        return $this;
    }

    protected function getFields(): ?array
    {
        return (empty($this->fields)) ? null : $this->fields;
    }

    protected function getFieldsAsString(): ?string
    {
        $fields = $this->getFields();
        return ($fields !== null)
            ? \implode(',', $fields)
            : null;
    }

    public function addField(string $field): self
    {
        $fields = $this->getFields();
        if ($fields === null) {
            $fields = [];
        }
        if (!\in_array($field, $fields, true)) {
            $fields[] = $field;
            $this->withFields($fields);
        }
        return $this;
    }

    /* ****************************************************************************************** */

    protected ?array $requiredFields = null;

    public function setRequiredFields(?array $requiredFields): self
    {
        $this->requiredFields = $requiredFields;
        return $this;
    }

    protected function getRequiredFields(): array
    {
        return $this->requiredFields ?? [];
    }

    /* ****************************************************************************************** */

    /**
     * Ensures parameter fields specified in $requiredArrays are set and are not empty.
     *
     * @param array $requiredFields Array of Param::XXX types that are
     *                              mandatory. All specified fields must be set
     *                              or exception is thrown.
     */
    protected function validate(array $requiredFields): void
    {
        foreach ($requiredFields as $field) {
            switch ($field) {
                case self::ACCESS_TOKEN:
                    Validator::assertNotEmpty($field, $this->getAccessToken());
                    break;
                case self::CITY:
                    Validator::assertNotEmpty($field, $this->getCity());
                    break;
                case self::COUNTRY:
                    Validator::assertNotEmpty($field, $this->getCountry());
                    break;
                case self::ID:
                    Validator::assertNotEmpty($field, $this->getSpeditionId());
                    break;
                case self::SPEDITION:
                    Validator::assertNotEmpty($field, $this->getSpedition());
                    break;
                case self::FIELDS:
                    Validator::assertNotEmpty($field, $this->getFields());
                    break;
                case self::LOCATION:
                    Validator::assertNotEmpty($field, $this->getLatitude());
                    Validator::assertNotEmpty($field, $this->getLongitude());
                    Validator::assertIsInRange('latitude', $this->getLatitude(), -90, 90);
                    Validator::assertIsInRange('longitude', $this->getLongitude(), -180, 180);
                    break;
                default:
                    throw new \RuntimeException("Unknown field: {$field}");
            }
        }
    }

    /* ****************************************************************************************** */

    /**
     * Returns URL encoded string representation of Params to be used with HTTP request as part
     * of query string (URL passed GET arguments).
     *
     * @param array|null $requiredFields Optional array of Param::XXX types that are
     *                                   mandatory (must be non-empty).
     *
     * @return string URL encoded string representation of set parameters.
     */
    public function toQueryString(?array $requiredFields = null): string
    {
        $requiredFields = $requiredFields ?? $this->getRequiredFields();
        $requiredFields = $requiredFields ?? [];
        $this->validate($requiredFields);

        $queryArgs = [
            self::ACCESS_TOKEN => $this->getAccessToken(),
            self::COUNTRY      => $this->getCountry(),
            self::SPEDITION    => $this->getSpedition(),
            self::CITY         => $this->getCity(),
            self::ID           => $this->getSpeditionId(),
            self::FIELDS       => $this->getFieldsAsString(),
            self::LOCATION     => $this->getLocationAsString(),
        ];

        if (!\array_key_exists(self::ACCESS_TOKEN, $queryArgs)) {
            $accessToken = $this->getAccessToken();
            if ($accessToken !== null) {
                $queryArgs[ self::ACCESS_TOKEN ] = $accessToken;
            }
        }

        $filtered = \array_filter($queryArgs, static function($value) {
            return $value !== null;
        });

        return \http_build_query($filtered);
    }
} // end of class
