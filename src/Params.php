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

    /**
     * Returns new instance of Params
     */
    public static function create(): self
    {
        return new self();
    }

    /* ****************************************************************************************** */

    /**
     * @var null|string
     */
    protected $accessToken = null;

    /**
     * Sets access token to be used with API calls.
     *
     * @param string $accessToken Access token to be used with API calls.
     */
    public function withAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * Returns access token to be used with API calls.
     */
    protected function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /* ****************************************************************************************** */

    /**
     * @var null|string
     */
    protected $country = null;

    /**
     * Sets country code to be used with API calls.
     *
     * @param string $country Country code to be used with API calls.
     */
    public function withCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Returns country code to be used with API calls.
     */
    protected function getCountry(): ?string
    {
        return $this->country;
    }

    /* ****************************************************************************************** */

    /**
     * @var null|string
     */
    protected $city = null;

    /**
     * Sets city name to be used with API calls.
     *
     * @param string $city City name to be used with API calls.
     */
    public function withCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Returns city name to be used with API calls.
     */
    protected function getCity(): ?string
    {
        return $this->city;
    }

    /* ****************************************************************************************** */

    /**
     * @var null|array
     */
    protected $speditions = null;

    /**
     * Sets list of spedition codes to be used with API calls.
     *
     * @param array $speditions List of spedition codes to be used with API calls.
     */
    public function withSpeditions(array $speditions): self
    {
        $this->speditions = $speditions;
        return $this;
    }

    /**
     * Returns list of spedition codes to be used with API calls.
     *
     * @param string $spedition Spedition code to be added to the list.
     */
    public function withSpedition(string $spedition): self
    {
        if ($this->speditions === null) {
            $this->speditions = [];
        }

        $this->speditions[] = $spedition;
        return $this;
    }

    /**
     * Returns list of spedition codes to be used with API calls.
     */
    protected function getSpeditions(): ?array
    {
        return $this->speditions;
    }

    /* ****************************************************************************************** */

    /**
     * @var null|string
     */
    protected $speditionId = null;

    /**
     * Sets spedition ID to be used with API calls.
     *
     * @param string $speditionId Spedition ID to be used with API calls.
     */
    public function withSpeditionId(string $speditionId): self
    {
        $this->speditionId = $speditionId;
        return $this;
    }

    /**
     * Returns spedition ID to be used with API calls.
     */
    protected function getSpeditionId(): ?string
    {
        return $this->speditionId;
    }

    /* ****************************************************************************************** */

    /**
     * @var null|float
     */
    protected $latitude  = null;

    /**
     * @var null|float
     */
    protected $longitude = null;

    /**
     * Sets location to be used with API calls.
     *
     * @param float|null $latitude  Latitude to be used with API calls.
     * @param float|null $longitude Longitude to be used with API calls.
     */
    public function withLocation(?float $latitude, ?float $longitude): self
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Returns latitude to be used with API calls.
     */
    protected function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Returns longitude to be used with API calls.
     */
    protected function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Returns location to be used with API calls.
     */
    protected function getLocationAsString(): ?string
    {
        if ($this->latitude === null || $this->longitude === null) {
            return null;
        }
        return sprintf('%f,%f', $this->latitude, $this->longitude);
    }

    /* ****************************************************************************************** */

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * Sets list of fields to be used with API calls.
     *
     * @param array|null $fields List of fields to be used with API calls.
     */
    public function withFields(?array $fields): self
    {
        $fields = $fields ?? [];
        $this->fields = $fields;
        return $this;
    }

    /**
     * Returns list of fields to be used with API calls.
     */
    protected function getFields(): ?array
    {
        return (empty($this->fields)) ? null : $this->fields;
    }

    /**
     * Returns list of fields to be used with API calls as string.
     */
    protected function getFieldsAsString(): ?string
    {
        return $this->arrayToString($this->getFields());
    }

    /**
     * Adds field to the list of fields to be used with API calls.
     *
     * @param string $field Field to be added to the list.
     */
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

    /**
     * @var null|array
     */
    protected $requiredFields = null;

    /**
     * Sets list of required fields to be used with API calls.
     *
     * @param array|null $requiredFields List of required fields to be used with API calls.
     */
    public function setRequiredFields(?array $requiredFields): self
    {
        $this->requiredFields = $requiredFields;
        return $this;
    }

    /**
     * Returns list of required fields to be used with API calls.
     */
    protected function getRequiredFields(): array
    {
        return $this->requiredFields ?? [];
    }

    /* ****************************************************************************************** */

    /**
     * @var null|string
     */
    protected $searchQuery = null;

    /**
     * Sets search query to be used with API calls.
     *
     * @param string $searchQuery Search query to be used with API calls.
     */
    public function withSearchQuery(string $searchQuery): self
    {
        $this->searchQuery = $searchQuery;
        return $this;
    }

    /**
     * Returns search query to be used with API calls.
     */
    protected function getSearchQuery(): ?string
    {
        return $this->searchQuery;
    }

    /* ****************************************************************************************** */

    /**
     * @var null|int
     */
    protected $limit = null;

    /**
     * Sets limit to be used with API calls.
     *
     * @param int $limit Limit to be used with API calls.
     */
    public function withLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Returns limit to be used with API calls.
     */
    protected function getLimit(): ?int
    {
        return $this->limit;
    }

    /* ****************************************************************************************** */

    /**
     * @var null|string
     */
    protected $language = null;

    /**
     * Sets language to be used with API calls.
     *
     * @param string $language Language to be used with API calls.
     */
    public function withLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Returns language to be used with API calls.
     */
    protected function getLanguage(): ?string
    {
        return $this->language;
    }

    /* ****************************************************************************************** */

    /**
     * @var null|array
     */
    protected $payments = null;

    /**
     * Sets payment to be used with API calls.
     *
     * @param string $payment Payment to be used with API calls.
     */
    public function withPayment(string $payment): self
    {
        if ($this->payments === null) {
            $this->payments = [];
        }
        $this->payments[] = $payment;
        return $this;
    }

    /**
     * Sets payments to be used with API calls.
     *
     * @param array|null $payments Payments to be used with API calls.
     */
    public function withPayments(?array $payments): self
    {
        $this->payments = $payments;
        return $this;
    }

    /**
     * Returns payments to be used with API calls.
     */
    protected function getPayments(): ?array
    {
        return $this->payments;
    }

    /**
     * Returns payments to be used with API calls as string.
     */
    protected function getPaymentsAsString(): ?string
    {
        return $this->arrayToString($this->getPayments());
    }

    /* ****************************************************************************************** */

    /**
     * @var null|array
     */
    protected $services = null;

    /**
     * Sets service to be used with API calls.
     *
     * @param string $service Service to be used with API calls.
     */
    public function withService(string $service): self
    {
        if ($this->services === null) {
            $this->services = [];
        }
        $this->services[] = $service;
        return $this;
    }

    /**
     * Sets services to be used with API calls.
     *
     * @param array|null $services Services to be used with API calls.
     */
    public function withServices(?array $services): self
    {
        $this->services = $services;
        return $this;
    }

    /**
     * Returns services to be used with API calls.
     */
    protected function getServices(): ?array
    {
        return $this->services;
    }

    /**
     * Returns services to be used with API calls as string.
     */
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

    /**
     * Returns array of Param::XXX types that are mandatory (must be non-empty).
     *
     * @param array|null $data Optional array to be converted to string orr NULL if $array is NULL
     */
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
                \array_map(static function (string $item): string {
                    return \trim($item);
                },
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
                $queryArgs[self::ACCESS_TOKEN] = $accessToken;
            }
        }

        // Remove all null-value query arguments.
        $filtered = \array_filter($queryArgs, static function ($value): bool {
            return $value !== null;
        });

        return \http_build_query($filtered);
    }
} // end of class
