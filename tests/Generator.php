<?php

namespace OlzaLogistic\PpApi\Client\Tests;

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

use OlzaLogistic\PpApi\Client\Model\PickupPoint as PP;

/**
 * Generates array with the structure as PP API response
 */
class Generator
{
    use \OlzaLogistic\PpApi\Client\Tests\Traits\TestHelpersTrait;

    public static function data(): self
    {
        return new static();
    }

    /* ****************************************************************************************** */

    /**
     * Generates given number of random name lines. Value of 0 (zero) means
     * the count is randomized between 1 and PickupPoint::MAX_NAME_LINES
     *
     * @param int $count Number or lines to generate.
     */
    public function withNames(int $count = 0): self
    {
        if ($count < 0) {
            throw new \InvalidArgumentException('Count must be positive integer or 0');
        }

        if ($count === 0) {
            $count = \mt_rand(1, PP::MAX_NAME_LINES);
        }

        for ($i = 0; $i < $count; $i++) {
            $this->data[ PP::KEY_GROUP_NAME ][] = $this->getRandomString("name{$i}");
        }

        return $this;
    }

    /**
     * Generates address entry.
     *
     * @param bool $fullOnly if FALSE, separate address fields (like i.e. City, Zip etc)
     *                       will also be filled. If TRUE, only full address and country
     *                       data is filled, with remaining fields set to null.
     *                       Default is FALSE.
     */
    public function withAddress(bool $fullOnly = false): self
    {
        $street = $this->getRandomString('street');
        $city = $this->getRandomString('city');
        $zip = $this->getRandomString('zip');
        $county = $this->getRandomString('county');
        $country = $this->getRandomString('country');

        $fullAddress = "{$street}, {$city} {$zip} {$county}, {$country}";
        $fullAddress = \str_replace(' ,', ',', $fullAddress);

        $this->data[ PP::KEY_GROUP_ADDRESS ] = [
            PP::KEY_FULL_ADDRESS => $fullAddress,
            PP::KEY_STREET       => $fullOnly ? null : $street,
            PP::KEY_ZIP          => $fullOnly ? null : $zip,
            PP::KEY_CITY         => $fullOnly ? null : $city,
            PP::KEY_COUNTY       => $fullOnly ? null : $county,
            PP::KEY_COUNTRY      => $fullOnly ? null : $country,
        ];
        return $this;
    }

    public function withContacts(?array $fields = null): self
    {
        if ($fields === null) {
            $fields = [
                PP::KEY_PHONE,
                PP::KEY_EMAIL,
            ];
        }

        if (\array_key_exists(PP::KEY_PHONE, $fields)) {
            $this->data[ PP::KEY_GROUP_CONTACTS ][ PP::KEY_PHONE ] = $this->getRandomString('phone');
        }
        if (\array_key_exists(PP::KEY_EMAIL, $fields)) {
            $this->data[ PP::KEY_GROUP_CONTACTS ][ PP::KEY_EMAIL ] = $this->getRandomString('email');
        }

        return $this;
    }

    public function withHours(): self
    {
        return $this;
    }

    public function withLocation(?int $latitude = null, ?int $longitude = null): self
    {
        $this->data[ PP::KEY_GROUP_LOCATION ] = [
            PP::KEY_LATITUDE  => $latitude ?? $this->getRandomFloat(-90, 90),
            PP::KEY_LONGITUDE => $longitude ?? $this->getRandomFloat(-180, 180),
        ];
        return $this;
    }

    /**
     * Helper to generate all data.
     */
    public function withAll(): self
    {
        return $this
            ->withNames()
            ->withAddress()
            ->withContacts()
            ->withHours()
            ->withLocation();
    }

    public function get(): array
    {
        return $this->data;
    }

    /* ****************************************************************************************** */

    protected array $data = [];

    protected function __construct()
    {
        $this->data = [
            PP::KEY_ID        => $this->getRandomString('id'),
            PP::KEY_SPEDITION => $this->getRandomString('sped'),
        ];
    }

} // end of class
