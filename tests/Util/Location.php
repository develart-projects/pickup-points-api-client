<?php

namespace OlzaLogistic\PpApi\Client\Tests\Util;

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2024 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

/**
 * Data class representing a location coordinates.
 */
class Location
{
    /**
     * @var float
     */
    public const MIN_LATITUDE = -90.0;

    /**
     * @var float
     */
    public const MAX_LATITUDE = 90.0;

    /**
     * @var float
     */
    public const MIN_LONGITUDE = -180.0;

    /**
     * @var float
     */
    public const MAX_LONGITUDE = 180.0;

    /* ****************************************************************************************** */

    public function __construct(?float $latitude = null, ?float $longitude = null)
    {
        $this->setLocation($latitude, $longitude);
    }

    /* ****************************************************************************************** */

    /**
     * Returns string representation of the object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->getLatitude()},{$this->getLongitude()}";
    }

    /* ****************************************************************************************** */

    /**
     * @var null|float
     */
    protected $latitude;

    /**
     * @var null|float
     */
    protected $longitude;

    /**
     * Returns current latitude
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Sets new latitude
     */
    public function setLatitude(?float $latitude): self
    {
        if ($latitude !== null) {
            if ($latitude < self::MIN_LATITUDE || $latitude > self::MAX_LATITUDE) {
                $msg = "Latitude must be between {self::MIN_LATITUDE} and {self::MAX_LATITUDE} inclusive.";
                throw new \InvalidArgumentException($msg);
            }
        }
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Returns current longitude
     */
    public function setLongitude(?float $longitude): self
    {
        if ($longitude !== null) {
            if ($longitude < self::MIN_LONGITUDE || $longitude > self::MAX_LONGITUDE) {
                $msg = "Longitude must be between {self::MIN_LONGITUDE} and {self::MAX_LONGITUDE} inclusive.";
                throw new \InvalidArgumentException($msg);
            }
        }
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Returns current longitude
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Sets both latitude and longitude at once.
     */
    public function setLocation(?float $latitude, ?float $longitude): self
    {
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);

        return $this;
    }

    /* ****************************************************************************************** */

    /**
     * Generate Random float value
     *
     * @param float $min    Lowest allowed value.
     * @param float $max    Highest allowed value.
     * @param int   $digits The optional number of decimal digits to round to.
     *                      Default 0 means not rounding.
     *
     * @return float
     */
    protected static function getRandomFloat(float $min, float $max, int $digits = 0): float
    {
        $result = $min + \mt_rand() / \mt_getrandmax() * ($max - $min);
        if ($digits > 0) {
            $result = \round($result, $digits);
        }

        return $result;
    }

    /**
     * Returns random latitude coordinate (WGS84)
     *
     * @param float $min    Minimal value (default: -90).
     * @param float $max    Maximal value (default: +90).
     * @param int   $digits The optional number of decimal digits to round to.
     *                      Default 0 means not rounding.
     *
     * @return float
     */
    public static function getRandomLatitude(float $min = self::MIN_LATITUDE,
                                             float $max = self::MAX_LATITUDE,
                                             int   $digits = 0): float
    {
        return static::getRandomFloat($min, $max, $digits);
    }

    /**
     * Returns random longitude coordinate (WGS84)
     *
     * @param float $min    Minimal value (default: -180).
     * @param float $max    Maximal value (default: +180).
     * @param int   $digits The optional number of decimal digits to round to.
     *                      Default 0 means not rounding.
     *
     * @return float
     */
    public static function getRandomLongitude(float $min = self::MIN_LONGITUDE,
                                              float $max = self::MAX_LONGITUDE,
                                              int   $digits = 0): float
    {
        return static::getRandomFloat($min, $max, $digits);
    }

    /**
     * Return randomized location withing specified radius from current $lat/$long.
     *
     * @param int $radiusInMeters Max allowed distance from current location.
     *
     * @throws \Exception
     */
    public function inRadius(int $radiusInMeters): self
    {
        $x0 = $this->getLongitude();
        $y0 = $this->getLatitude();

        $rd = $radiusInMeters / 111300; // about 111300 meters in one degree

        // hi-res, 0-1 range random number
        $resolution = 10000;
        $u = \random_int(0, $resolution) / $resolution;
        $v = \random_int(0, $resolution) / $resolution;

        $w = $rd * \sqrt($u);
        $t = 2 * M_PI * $v;
        $x = $w * \cos($t);
        $y = $w * \sin($t);

        $newLong = $x + $x0;
        $newLat = $y + $y0;

        return new self($newLat, $newLong);
    }

    /* ****************************************************************************************** */

    /**
     * Returns Location with random coordinates.
     */
    public static function getRandom(): self
    {
        return new self(static::getRandomLatitude(), static::getRandomLongitude());
    }

    /* ****************************************************************************************** */


    /**
     * Returns distance (in meters) to $other location.
     *
     * @param Location $other Location to calculate distance to.
     *
     * @return float
     * @throws \Exception
     */
    public function distance(self $other): float
    {
        $myLatitude = $this->getLatitude();
        $myLongitude = $this->getLongitude();
        $otherLatitude = $other->getLatitude();
        $otherLongitude = $other->getLongitude();

        if ($myLatitude === null || $myLongitude === null) {
            throw new \RuntimeException('Invalid my location coordinates');
        }
        if ($otherLatitude === null || $otherLongitude === null) {
            throw new \RuntimeException('Invalid other location coordinates');
        }

        $earthRadiusMeters = 6371000;

        $dLat = $this->degreesToRadians($otherLatitude - $myLatitude);
        $dLon = $this->degreesToRadians($otherLongitude - $myLongitude);

        $myLatitude = $this->degreesToRadians($myLatitude);
        $otherLatitude = $this->degreesToRadians($otherLatitude);

        $a = \sin($dLat / 2) * \sin($dLat / 2)
            + \sin($dLon / 2) * \sin($dLon / 2) * \cos($myLatitude) * \cos($otherLatitude);
        $c = 2 * \atan2(\sqrt($a), \sqrt(1 - $a));
        return (float)$earthRadiusMeters * $c;
    }

    /**
     * Converts degrees to radians.
     */
    protected function degreesToRadians(float $degrees): float
    {
        return $degrees * M_PI / 180;
    }

} // end of Location
