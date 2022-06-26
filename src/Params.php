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

use OlzaLogistic\PpApi\Client\Util\Validator;

class Params
{
    public const ACCESS_TOKEN = 'access_token';
    public const CITY         = 'city';
    public const COUNTRY      = 'country';
    public const FIELDS       = 'fields';
    public const ID           = 'id';
    public const LANGUAGE     = 'language';
    public const LIMIT        = 'limit';
    public const LOCATION     = 'location';
    public const PAYMENTS     = 'payments';
    public const SEARCH       = 'search';
    public const SERVICES     = 'services';
    public const SPEDITION    = 'spedition';

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

    protected ?array $speditions = null;

    public function withSpeditions(array $speditions): self
    {
        $this->speditions = $speditions;
        return $this;
    }

    public function withSpedition(string $spedition): self
    {
        if ($this->speditions === null) {
            $this->speditions = [];
        }

        $this->speditions[] = $spedition;
        return $this;
    }

    protected function getSpeditions(): ?array
    {
        return $this->speditions;
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
        return $this->arrayToString($this->getFields());
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

    protected ?string $searchQuery = null;

    public function withSearchQuery(string $searchQuery): self
    {
        $this->searchQuery = $searchQuery;
        return $this;
    }

    protected function getSearchQuery(): ?string
    {
        return $this->searchQuery;
    }

    /* ****************************************************************************************** */

    protected ?int $limit = null;

    public function withLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    protected function getLimit(): ?int
    {
        return $this->limit;
    }

    /* ****************************************************************************************** */

    protected ?string $language = null;

    public function withLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    protected function getLanguage(): ?string
    {
        return $this->language;
    }

    /* ****************************************************************************************** */

    protected ?array $payments = null;

    public function withPayment(string $payment): self
    {
        if ($this->payments === null) {
            $this->payments = [];
        }
        $this->payments[] = $payment;
        return $this;
    }

    public function withPayments(?array $payments): self
    {
        $this->payments = $payments;
        return $this;
    }

    protected function getPayments(): ?array
    {
        return $this->payments;
    }

    protected function getPaymentsAsString(): ?string
    {
        return $this->arrayToString($this->getPayments());
    }

    /* ****************************************************************************************** */

    protected ?array $services = null;

    public function withService(string $service): self
    {
        if ($this->services === null) {
            $this->services = [];
        }
        $this->services[] = $service;
        return $this;
    }

    public function withServices(?array $services): self
    {
        $this->services = $services;
        return $this;
    }

    protected function getServices(): ?array
    {
        return $this->services;
    }

    protected function getServicesAsString(): ?string
    {
        return $this->arrayToString($this->getServices());
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
                    Validator::assertNotEmpty($field, $this->getSpeditions());
                    break;
                case self::FIELDS:
                    Validator::assertNotEmpty($field, $this->getFields());
                    break;
                case self::SERVICES:
                    Validator::assertNotEmpty($field, $this->getServices());
                    break;
                case self::PAYMENTS:
                    Validator::assertNotEmpty($field, $this->getPayments());
                    break;
                case self::LOCATION:
                    $lat = $this->getLatitude();
                    $long = $this->getLongitude();
                    Validator::assertNotEmpty($field, $lat);
                    Validator::assertNotEmpty($field, $long);
                    /**
                     * @var float $lat
                     * @var float $long
                     */
                    Validator::assertIsInRange('latitude', $lat, -90, 90);
                    Validator::assertIsInRange('longitude', $long, -180, 180);
                    break;
                default:
                    throw new \RuntimeException("Unknown field: {$field}");
            }
        }
    }

    /* ****************************************************************************************** */

    protected function arrayToString(?array $data): ?string
    {
        return ($data !== null)
            ? \implode(',', $data)
            : null;
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
        $this->validate($requiredFields);

        $speditions = $this->getSpeditions();
        if (!empty($speditions)) {
            $speditions = \implode(',',
                \array_map(static fn(string $item): string => \trim($item),
                    $speditions));
        }

        $queryArgs = [
            // Keep keys sorted.
            self::ACCESS_TOKEN => $this->getAccessToken(),
            self::CITY         => $this->getCity(),
            self::COUNTRY      => $this->getCountry(),
            self::FIELDS       => $this->getFieldsAsString(),
            self::ID           => $this->getSpeditionId(),
            self::LANGUAGE     => $this->getLanguage(),
            self::LIMIT        => $this->getLimit(),
            self::LOCATION     => $this->getLocationAsString(),
            self::PAYMENTS     => $this->getPaymentsAsString(),
            self::SEARCH       => $this->getSearchQuery(),
            self::SERVICES     => $this->getServicesAsString(),
            self::SPEDITION    => $speditions,
        ];

        if (!\array_key_exists(self::ACCESS_TOKEN, $queryArgs)) {
            $accessToken = $this->getAccessToken();
            if ($accessToken !== null) {
                $queryArgs[ self::ACCESS_TOKEN ] = $accessToken;
            }
        }

        // Remove all null-value query arguments.
        $filtered = \array_filter($queryArgs, static fn($value): bool => $value !== null);

        return \http_build_query($filtered);
    }
} // end of class
