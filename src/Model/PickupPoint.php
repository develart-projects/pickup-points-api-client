<?php
declare(strict_types=1);

/*
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */

namespace OlzaLogistic\PpApi\Client\Model;

class PickupPoint
{
    /* ****************************************************************************************** */

    public const KEY_ID        = 'id';
    public const KEY_SPEDITION = 'spedition';

    /* ****************************************************************************************** */

    /**
     * Max number of name rows that can be returned in KEY_GROUP_NAME list.
     */
    public const MAX_NAME_LINES = 2;
    public const KEY_GROUP_NAME = 'names';

    /* ****************************************************************************************** */

    public const KEY_GROUP_ADDRESS = 'address';
    public const KEY_FULL_ADDRESS  = 'full';
    public const KEY_STREET        = 'street';
    public const KEY_ZIP           = 'zip';
    public const KEY_CITY          = 'city';
    public const KEY_COUNTY        = 'county';
    public const KEY_COUNTRY       = 'country';

    /* ****************************************************************************************** */

    public const KEY_GROUP_CONTACTS = 'contacts';
    public const KEY_PHONE          = 'phone';
    public const KEY_EMAIL          = 'email';

    /* ****************************************************************************************** */

    public const KEY_GROUP_HOURS = 'hours';
    public const KEY_MONDAY      = 'monday';
    public const KEY_TUESDAY     = 'tuesday';
    public const KEY_WEDNESDAY   = 'wednesday';
    public const KEY_THURSDAY    = 'thursday';
    public const KEY_FRIDAY      = 'friday';
    public const KEY_SATURDAY    = 'saturday';
    public const KEY_SUNDAY      = 'sunday';

    public const KEY_HOURS    = 'hours';
    public const KEY_BREAK    = 'break';
    public const KEY_OPEN_247 = 'open247';

    /* ****************************************************************************************** */

    public const KEY_GROUP_LOCATION = 'location';
    public const KEY_LATITUDE       = 'latitude';
    public const KEY_LONGITUDE      = 'longitude';

    /* ****************************************************************************************** */

    public const KEY_GROUP_SERVICES = 'services';
    public const KEY_COD            = 'cod';
    public const KEY_AVAILABLE      = 'available';
    public const KEY_GROUP_PAYMENTS = 'payments';

    /* ****************************************************************************************** */
    /* ****************************************************************************************** */
    /* ****************************************************************************************** */

    /**
     * Pickup point ID assigned by the spedition.
     *
     * NOTE: value is always stored lower cased.
     */
    protected string $speditionId;

    /**
     * Returns Id of the pickup point as assigned by the spedition
     * (their internal ID as provided by data source)
     */
    public function getSpeditionId(): string
    {
        return $this->speditionId;
    }

    /**
     * Sets Id of the pickup point as assigned by the spedition (their
     * internal ID as provided by data source)
     */
    protected function setSpeditionId(string $speditionId): self
    {
        $this->speditionId = $speditionId;
        return $this;
    }

    /* ****************************************************************************************** */

    /**
     * Code of the spedition (carrier) that handles this pickup point.
     */
    private string $spedition;

    /**
     * Returns speditions's code (identifier), i.e. 'HUP-CS'
     */
    public function getSpedition(): string
    {
        return $this->spedition;
    }

    /**
     * Sets speditions's code (identifier), i.e. 'HUP-CS'
     */
    protected function setSpedition(string $spedition): self
    {
        $spedition = \trim($spedition);
        if ($spedition === '') {
            throw new \RuntimeException('Spedition code cannot be empty');
        }

        $this->spedition = $spedition;
        return $this;
    }

    /* ****************************************************************************************** */
    /* ****************************************************************************************** */
    /* ****************************************************************************************** */

    private string $name1;

    /**
     * Returns first name line of the pickup point.
     *
     * @return string
     */
    public function getName1(): string
    {
        return $this->name1;
    }

    /**
     * Sets first name line of the pickup point.
     *
     * @param string $name1 Name line 1
     *
     * @return PickupPoint
     */
    protected function setName1(string $name1): self
    {
        $this->name1 = \trim($name1);
        return $this;
    }

    private ?string $name2 = null;

    /**
     * Returns second name line of the pickup point.
     *
     * @return string|null
     */
    public function getName2(): ?string
    {
        return $this->name2;
    }

    /**
     * Sets second name line of the pickup point.
     *
     * @param string|null $name2 Name line 2
     *
     * @return PickupPoint
     */
    protected function setName2(?string $name2): self
    {
        $this->name2 = ($name2 !== null) ? \trim($name2) : null;
        return $this;
    }

    /**
     * Helper method that returns all name lines as single array.
     */
    public function getNames(): array
    {
        $names = [
            $this->getName1(),
            $this->getName2(),
        ];
        return array_filter($names, static function (?string $name) {
            return !empty($name);
        });
    }

    /* ****************************************************************************************** */
    /* ****************************************************************************************** */
    /* ****************************************************************************************** */

    protected ?string $fullAddress = null;

    /**
     * Returns full address of the pickup point.
     *
     * @return string
     */
    public function getFullAddress(): string
    {
        if ($this->fullAddress === null) {
            throw new \RuntimeException('Full address is not set');
        }
        return $this->fullAddress;
    }

    /**
     * Sets full address of the pickup point.
     *
     * @param string $fullAddress Full address
     *
     * @return PickupPoint
     */
    protected function setFullAddress(string $fullAddress): self
    {
        $this->fullAddress = \trim($fullAddress);
        return $this;
    }

    /* ****************************************************************************************** */

    protected ?string $street = null;

    /**
     * Returns street name of the pickup point.
     *
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Sets street name of the pickup point.
     *
     * @param string|null $street Street name
     *
     * @return PickupPoint
     */
    protected function setStreet(?string $street): self
    {
        $this->street = ($street !== null) ? \trim($street) : null;
        return $this;
    }

    /* ****************************************************************************************** */

    protected ?string $zip = null;

    /**
     * Returns ZIP code of the pickup point.
     *
     * @return string|null
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * Sets ZIP code of the pickup point.
     *
     * @param string|null $zip ZIP code
     *
     * @return PickupPoint
     */
    protected function setZip(?string $zip): self
    {
        $this->zip = ($zip !== null) ? \trim($zip) : null;
        return $this;
    }

    /* ****************************************************************************************** */

    protected ?string $city = null;

    /**
     * Returns city of the pickup point.
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Sets city of the pickup point.
     *
     * @param string|null $city City
     *
     * @return PickupPoint
     */
    protected function setCity(?string $city): self
    {
        $this->city = ($city !== null) ? \trim($city) : null;
        return $this;
    }

    /* ****************************************************************************************** */

    protected ?string $county = null;

    /**
     * Returns county of the pickup point.
     *
     * @return string|null
     */
    public function getCounty(): ?string
    {
        return $this->county;
    }

    /**
     * Sets county of the pickup point.
     *
     * @param string|null $county County
     *
     * @return PickupPoint
     */
    protected function setCounty(?string $county): self
    {
        $this->county = ($county !== null) ? \trim($county) : null;
        return $this;
    }

    /* ****************************************************************************************** */

    /**
     * Street address' country field.
     *
     * NOTE: value is always stored lower cased.
     */
    protected ?string $country = null;

    /**
     * Returns country of the pickup point.
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Sets country of the pickup point.
     *
     * @param string|null $country Country
     *
     * @return PickupPoint
     */
    protected function setCountry(?string $country): self
    {
        $this->country = ($country !== null) ? \strtolower(\trim($country)) : null;
        return $this;
    }

    /**
     * Returns all pickup point location address. Except for "full", all other
     * keys are not present if there's no data.
     *
     * @return null[]|string[]
     */
    public function getAddress(): array
    {
        $result = [
            static::KEY_FULL_ADDRESS => $this->getFullAddress(),
            static::KEY_STREET       => $this->getStreet(),
            static::KEY_ZIP          => $this->getZip(),
            static::KEY_CITY         => $this->getCity(),
            static::KEY_COUNTY       => $this->getCounty(),
            static::KEY_COUNTRY      => $this->getCountry(),
        ];

        // Filter out empty entries
        return array_filter($result, static function ($value) {
            return !empty($value);
        });
    }

    /* ****************************************************************************************** */
    /* ****************************************************************************************** */
    /* ****************************************************************************************** */

    protected ?string $phone = null;

    /**
     * Returns phone number of the pickup point.
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Sets phone number of the pickup point.
     *
     * @param string|null $phone Phone number
     *
     * @return PickupPoint
     */
    protected function setPhone(?string $phone): self
    {
        $this->phone = ($phone !== null) ? \trim($phone) : null;
        return $this;
    }

    /* ****************************************************************************************** */

    protected ?string $email = null;

    /**
     * Returns email address of the pickup point.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets email address of the pickup point.
     *
     * @param string|null $email Email address
     *
     * @return PickupPoint
     */
    protected function setEmail(?string $email): self
    {
        $this->email = ($email !== null) ? \trim($email) : null;
        return $this;
    }

    /**
     * Helper methods that groups all pickup point contact types into single array.
     */
    public function getContacts(): array
    {
        return [
            static::KEY_PHONE => $this->getPhone(),
            static::KEY_EMAIL => $this->getEmail(),
        ];
    }

    /* ****************************************************************************************** */
    /* ****************************************************************************************** */
    /* ****************************************************************************************** */

    /**
     * Validates and sanitizes hour string. Expects HH:MM-HH:MM input string or null.
     * Throws exception if input is not correctly formatted.
     */
    protected function sanitizeHours(?string $hour): ?string
    {
        if (\is_string($hour)) {
            $hour = \trim($hour);
        }
        if (empty($hour)) {
            $hour = null;
        }
        if (($hour !== null) && !\preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $hour)) {
            throw new \RuntimeException("Invalid format, expected 'HH:MM-HH:MM': {$hour}");
        }
        return $hour;
    }

    /* ****************************************************************************************** */

    protected bool $open247 = false;

    /**
     * Returns true if pickup point is open 24/7.
     *
     * @return bool
     */
    public function isOpen247(): bool
    {
        return $this->open247;
    }

    /**
     * Sets if pickup point is open 24/7.
     *
     * @param bool $open247 True if open 24/7, false otherwise
     *
     * @return PickupPoint
     */
    public function setOpen247(bool $open247): self
    {
        $this->open247 = $open247;
        return $this;
    }


    protected ?string $mondayHours = null;

    /**
     * Returns opening hours for Monday.
     *
     * @return string|null
     */
    public function getMondayHours(): ?string
    {
        return $this->mondayHours;
    }

    /**
     * Sets opening hours for Monday.
     *
     * @param string|null $mondayHours Opening hours
     *
     * @return PickupPoint
     */
    protected function setMondayHours(?string $mondayHours): self
    {
        $this->mondayHours = $this->sanitizeHours($mondayHours);
        return $this;
    }

    protected ?string $mondayBreak = null;

    /**
     * Returns break hours for Monday.
     *
     * @return string|null
     */
    public function getMondayBreak(): ?string
    {
        return $this->mondayBreak;
    }

    /**
     * Sets break hours for Monday.
     *
     * @param string|null $mondayBreak Break hours
     *
     * @return PickupPoint
     */
    protected function setMondayBreak(?string $mondayBreak): self
    {
        $this->mondayBreak = $this->sanitizeHours($mondayBreak);
        return $this;
    }

    protected ?string $tuesdayHours = null;

    /**
     * Returns opening hours for Tuesday.
     *
     * @return string|null
     */
    public function getTuesdayHours(): ?string
    {
        return $this->tuesdayHours;
    }

    /**
     * Sets opening hours for Tuesday.
     *
     * @param string|null $tuesdayHours Opening hours
     *
     * @return PickupPoint
     */
    protected function setTuesdayHours(?string $tuesdayHours): self
    {
        $this->tuesdayHours = $this->sanitizeHours($tuesdayHours);
        return $this;
    }

    protected ?string $tuesdayBreak = null;

    /**
     * Returns break hours for Tuesday.
     *
     * @return string|null
     */
    public function getTuesdayBreak(): ?string
    {
        return $this->tuesdayBreak;
    }

    /**
     * Sets break hours for Tuesday.
     *
     * @param string|null $tuesdayBreak Break hours
     *
     * @return PickupPoint
     */
    protected function setTuesdayBreak(?string $tuesdayBreak): self
    {
        $this->tuesdayBreak = $this->sanitizeHours($tuesdayBreak);
        return $this;
    }

    protected ?string $wednesdayHours = null;

    /**
     * Returns opening hours for Wednesday.
     *
     * @return string|null
     */
    public function getWednesdayHours(): ?string
    {
        return $this->wednesdayHours;
    }

    /**
     * Sets opening hours for Wednesday.
     *
     * @param string|null $wednesdayHours Opening hours
     *
     * @return PickupPoint
     */
    protected function setWednesdayHours(?string $wednesdayHours): self
    {
        $this->wednesdayHours = $this->sanitizeHours($wednesdayHours);
        return $this;
    }

    protected ?string $wednesdayBreak = null;

    /**
     * Returns break hours for Wednesday.
     *
     * @return string|null
     */
    public function getWednesdayBreak(): ?string
    {
        return $this->wednesdayBreak;
    }

    /**
     * Sets break hours for Wednesday.
     *
     * @param string|null $wednesdayBreak Break hours
     *
     * @return PickupPoint
     */
    protected function setWednesdayBreak(?string $wednesdayBreak): self
    {
        $this->wednesdayBreak = $this->sanitizeHours($wednesdayBreak);
        return $this;
    }


    protected ?string $thursdayHours = null;

    /**
     * Returns opening hours for Thursday.
     *
     * @return string|null
     */
    public function getThursdayHours(): ?string
    {
        return $this->thursdayHours;
    }

    /**
     * Sets opening hours for Thursday.
     *
     * @param string|null $thursdayHours Opening hours
     *
     * @return PickupPoint
     */
    protected function setThursdayHours(?string $thursdayHours): self
    {
        $this->thursdayHours = $this->sanitizeHours($thursdayHours);
        return $this;
    }

    protected ?string $thursdayBreak = null;

    /**
     * Returns break hours for Thursday.
     *
     * @return string|null
     */
    public function getThursdayBreak(): ?string
    {
        return $this->thursdayBreak;
    }

    /**
     * Sets break hours for Thursday.
     *
     * @param string|null $thursdayBreak Break hours
     *
     * @return PickupPoint
     */
    protected function setThursdayBreak(?string $thursdayBreak): self
    {
        $this->thursdayBreak = $this->sanitizeHours($thursdayBreak);
        return $this;
    }

    protected ?string $fridayHours = null;

    /**
     * Returns opening hours for Friday.
     *
     * @return string|null
     */
    public function getFridayHours(): ?string
    {
        return $this->fridayHours;
    }

    /**
     * Sets opening hours for Friday.
     *
     * @param string|null $fridayHours Opening hours
     *
     * @return PickupPoint
     */
    protected function setFridayHours(?string $fridayHours): self
    {
        $this->fridayHours = $this->sanitizeHours($fridayHours);
        return $this;
    }

    protected ?string $fridayBreak = null;

    /**
     * Returns break hours for Friday.
     *
     * @return string|null
     */
    public function getFridayBreak(): ?string
    {
        return $this->fridayBreak;
    }

    /**
     * Sets break hours for Friday.
     *
     * @param string|null $fridayBreak Break hours
     *
     * @return PickupPoint
     */
    protected function setFridayBreak(?string $fridayBreak): self
    {
        $this->fridayBreak = $this->sanitizeHours($fridayBreak);
        return $this;
    }

    protected ?string $saturdayHours = null;

    /**
     * Returns opening hours for Saturday.
     *
     * @return string|null
     */
    public function getSaturdayHours(): ?string
    {
        return $this->saturdayHours;
    }

    /**
     * Sets opening hours for Saturday.
     *
     * @param string|null $saturdayHours Opening hours
     *
     * @return PickupPoint
     */
    protected function setSaturdayHours(?string $saturdayHours): self
    {
        $this->saturdayHours = $this->sanitizeHours($saturdayHours);
        return $this;
    }

    protected ?string $saturdayBreak = null;

    /**
     * Returns break hours for Saturday.
     *
     * @return string|null
     */
    public function getSaturdayBreak(): ?string
    {
        return $this->saturdayBreak;
    }

    /**
     * Sets break hours for Saturday.
     *
     * @param string|null $saturdayBreak Break hours
     *
     * @return PickupPoint
     */
    protected function setSaturdayBreak(?string $saturdayBreak): self
    {
        $this->saturdayBreak = $this->sanitizeHours($saturdayBreak);
        return $this;
    }

    protected ?string $sundayHours = null;

    /**
     * Returns opening hours for Sunday.
     *
     * @return string|null
     */
    public function getSundayHours(): ?string
    {
        return $this->sundayHours;
    }

    /**
     * Sets opening hours for Sunday.
     *
     * @param string|null $sundayHours Opening hours
     *
     * @return PickupPoint
     */
    protected function setSundayHours(?string $sundayHours): self
    {
        $this->sundayHours = $this->sanitizeHours($sundayHours);
        return $this;
    }

    protected ?string $sundayBreak = null;

    /**
     * Returns break hours for Sunday.
     *
     * @return string|null
     */
    public function getSundayBreak(): ?string
    {
        return $this->sundayBreak;
    }

    /**
     * Sets break hours for Sunday.
     *
     * @param string|null $sundayBreak Break hours
     *
     * @return PickupPoint
     */
    protected function setSundayBreak(?string $sundayBreak): self
    {
        $this->sundayBreak = $this->sanitizeHours($sundayBreak);
        return $this;
    }

    public function getHours(): array
    {
        $hours = [
            static::KEY_OPEN_247  => $this->isOpen247(),
            static::KEY_MONDAY    => [
                static::KEY_HOURS => $this->getMondayHours(),
                static::KEY_BREAK => $this->getMondayBreak(),
            ],
            static::KEY_TUESDAY   => [
                static::KEY_HOURS => $this->getTuesdayHours(),
                static::KEY_BREAK => $this->getTuesdayBreak(),
            ],
            static::KEY_WEDNESDAY => [
                static::KEY_HOURS => $this->getWednesdayHours(),
                static::KEY_BREAK => $this->getWednesdayBreak(),
            ],
            static::KEY_THURSDAY  => [
                static::KEY_HOURS => $this->getThursdayHours(),
                static::KEY_BREAK => $this->getThursdayBreak(),
            ],
            static::KEY_FRIDAY    => [
                static::KEY_HOURS => $this->getFridayHours(),
                static::KEY_BREAK => $this->getFridayBreak(),
            ],
            static::KEY_SATURDAY  => [
                static::KEY_HOURS => $this->getSaturdayHours(),
                static::KEY_BREAK => $this->getSaturdayBreak(),
            ],
            static::KEY_SUNDAY    => [
                static::KEY_HOURS => $this->getSundayHours(),
                static::KEY_BREAK => $this->getSundayBreak(),
            ],
        ];

        // Remove days without opening hours given
        return \array_filter($hours, static function ($item) {
            return \is_array($item)
                ? $item[static::KEY_HOURS] !== null
                : $item !== null;
        });
    }

    /* ****************************************************************************************** */

    protected ?string $latitude = null;

    /**
     * Returns latitude.
     *
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    protected ?string $longitude = null;

    /**
     * Returns longitude.
     *
     * @return string|null
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * Returns location coordinates as array or null if coordinates are not set.
     */
    public function getLocation(): ?array
    {
        $latitude = $this->getLatitude();
        $longitude = $this->getLongitude();

        $result = null;
        if ($latitude !== null && $longitude !== null) {
            $result = [
                static::KEY_LATITUDE  => $latitude,
                static::KEY_LONGITUDE => $longitude,
            ];
        }

        return $result;
    }

    /**
     * @param string|int|float|null $latitude
     * @param string|int|float|null $longitude
     */
    protected function setLocation($latitude, $longitude): self
    {
        $this->assertValidCoord($latitude);
        $this->assertValidCoord($longitude);

        if ($latitude === null || (\is_string($latitude) && \trim($latitude) === '')) {
            $latitude = null;
        } else {
            $latitude = (string)$latitude;
        }

        if ($longitude === null || (\is_string($longitude) && \trim($longitude) === '')) {
            $longitude = null;
        } else {
            $longitude = (string)$longitude;
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @param string|int|float|null $val
     */
    protected function assertValidCoord($val): void
    {
        if ($val !== null) {
            if (\is_string($val) || \is_int($val) || \is_float($val)) {
                $val = (string)$val;
                if (\trim($val) === '') {
                    throw new \InvalidArgumentException('Invalid coordinate value given.');
                }
            } else {
                throw new \InvalidArgumentException('Invalid coordinate value given.');
            }
        }
    }

    /* ****************************************************************************************** */

    protected ?string $notes = null;

    /**
     * Returns notes.
     *
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    protected function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    /* ****************************************************************************************** */
    /* ****************************************************************************************** */
    /* ****************************************************************************************** */

    final protected function __construct()
    {
        // dummy
    }

    /* ****************************************************************************************** */

    /**
     * Constructs instance of PickupPoint filled PP with data returned in API response.
     * NOTE: $ppData must point to single PP data node (element of 'data/items' array).
     *
     * @param array $ppData Single PP data.
     */
    public static function fromApiResponse(array $ppData): self
    {
        $pp = (new static())
            ->setSpeditionId($ppData[static::KEY_ID])
            ->setSpedition($ppData[static::KEY_SPEDITION]);

        if (\array_key_exists(static::KEY_GROUP_NAME, $ppData)) {
            $pp->setName1($ppData[static::KEY_GROUP_NAME][0] ?? '???');
            if (isset($ppData[static::KEY_GROUP_NAME][1])) {
                $pp->setName2($ppData[static::KEY_GROUP_NAME][1]);
            }
        }

        if (\array_key_exists(static::KEY_GROUP_ADDRESS, $ppData)) {
            $node = $ppData[static::KEY_GROUP_ADDRESS];
            $pp
                ->setFullAddress($node[static::KEY_FULL_ADDRESS] ?? '???')
                ->setStreet($node[static::KEY_STREET] ?? null)
                ->setZip($node[static::KEY_ZIP] ?? null)
                ->setCity($node[static::KEY_CITY] ?? null)
                ->setCounty($node[static::KEY_COUNTY] ?? null)
                ->setCountry($node[static::KEY_COUNTRY] ?? null);
        }

        if (\array_key_exists(static::KEY_GROUP_CONTACTS, $ppData)) {
            $node = $ppData[static::KEY_GROUP_CONTACTS];
            if (\array_key_exists(static::KEY_PHONE, $node)) {
                $pp->setPhone($node[static::KEY_PHONE]);
            }
            if (\array_key_exists(static::KEY_EMAIL, $node)) {
                $pp->setEmail($node[static::KEY_EMAIL]);
            }
        }

        if (\array_key_exists(static::KEY_GROUP_HOURS, $ppData)) {
            $hrsGroup = $ppData[static::KEY_GROUP_HOURS];

            if (\array_key_exists(static::KEY_MONDAY, $hrsGroup)) {
                $hrsNode = $hrsGroup[static::KEY_MONDAY];
                $pp->setMondayHours($hrsNode[static::KEY_HOURS] ?? null);
                $pp->setMondayBreak($hrsNode[static::KEY_BREAK] ?? null);
            }
            if (\array_key_exists(static::KEY_TUESDAY, $hrsGroup)) {
                $hrsNode = $hrsGroup[static::KEY_TUESDAY];
                $pp->setTuesdayHours($hrsNode[static::KEY_HOURS] ?? null);
                $pp->setTuesdayBreak($hrsNode[static::KEY_BREAK] ?? null);
            }
            if (\array_key_exists(static::KEY_WEDNESDAY, $hrsGroup)) {
                $hrsNode = $hrsGroup[static::KEY_WEDNESDAY];
                $pp->setWednesdayHours($hrsNode[static::KEY_HOURS] ?? null);
                $pp->setWednesdayBreak($hrsNode[static::KEY_BREAK] ?? null);
            }
            if (\array_key_exists(static::KEY_THURSDAY, $hrsGroup)) {
                $hrsNode = $hrsGroup[static::KEY_THURSDAY];
                $pp->setThursdayHours($hrsNode[static::KEY_HOURS] ?? null);
                $pp->setThursdayBreak($hrsNode[static::KEY_BREAK] ?? null);
            }
            if (\array_key_exists(static::KEY_FRIDAY, $hrsGroup)) {
                $hrsNode = $hrsGroup[static::KEY_FRIDAY];
                $pp->setFridayHours($hrsNode[static::KEY_HOURS] ?? null);
                $pp->setFridayBreak($hrsNode[static::KEY_BREAK] ?? null);
            }
            if (\array_key_exists(static::KEY_SATURDAY, $hrsGroup)) {
                $hrsNode = $hrsGroup[static::KEY_SATURDAY];
                $pp->setSaturdayHours($hrsNode[static::KEY_HOURS] ?? null);
                $pp->setSaturdayBreak($hrsNode[static::KEY_BREAK] ?? null);
            }
            if (\array_key_exists(static::KEY_SUNDAY, $hrsGroup)) {
                $hrsNode = $hrsGroup[static::KEY_SUNDAY];
                $pp->setSundayHours($hrsNode[static::KEY_HOURS] ?? null);
                $pp->setSundayBreak($hrsNode[static::KEY_BREAK] ?? null);
            }
        }

        if (\array_key_exists(static::KEY_GROUP_LOCATION, $ppData)) {
            $node = $ppData[static::KEY_GROUP_LOCATION];
            $pp->setLocation(
                $node[static::KEY_LATITUDE] ?? null,
                $node[static::KEY_LONGITUDE] ?? null
            );
        }

        return $pp;
    }

} // end of class
