<?php

namespace OlzaLogistic\PpApi\Client\Model;

class PickupPoint
{
    /** ********************************************************************************************* **/

    /**
     * @var string
     */
    public const KEY_ID = 'id';

    /**
     * @var string
     */
    public const KEY_SPEDITION = 'spedition';

    /** ********************************************************************************************* **/

    public const KEY_GROUP_NAME = 'name';

    /** ********************************************************************************************* **/

    /**
     * @var string
     */
    public const KEY_GROUP_ADDRESS = 'address';

    /**
     * @var string
     */
    public const KEY_FULL_ADDRESS = 'full';

    /**
     * @var string
     */
    public const KEY_STREET = 'street';

    /**
     * @var string
     */
    public const KEY_ZIP = 'zip';

    /**
     * @var string
     */
    public const KEY_CITY = 'city';

    /**
     * @var string
     */
    public const KEY_COUNTY = 'county';

    /**
     * @var string
     */
    public const KEY_COUNTRY = 'country';

    /** ********************************************************************************************* **/

    /**
     * @var string
     */
    public const KEY_GROUP_CONTACTS = 'contacts';

    /**
     * @var string
     */
    public const KEY_PHONE = 'phone';

    /**
     * @var string
     */
    public const KEY_EMAIL = 'email';

    /** ********************************************************************************************* **/

    /**
     * @var string
     */
    public const KEY_GROUP_HOURS = 'hours';

    /**
     * @var string
     */
    public const KEY_MONDAY = 'monday';

    /**
     * @var string
     */
    public const KEY_TUESDAY = 'tuesday';

    /**
     * @var string
     */
    public const KEY_WEDNESDAY = 'wednesday';

    /**
     * @var string
     */
    public const KEY_THURSDAY = 'thursday';

    /**
     * @var string
     */
    public const KEY_FRIDAY = 'friday';

    /**
     * @var string
     */
    public const KEY_SATURDAY = 'saturday';

    /**
     * @var string
     */
    public const KEY_SUNDAY = 'sunday';


    /**
     * @var string
     */
    public const KEY_HOURS = 'hours';

    /**
     * @var string
     */
    public const KEY_BREAK = 'break';

    /** ********************************************************************************************* **/

    /**
     * @var string
     */
    public const KEY_GROUP_LOCATION = 'location';

    /**
     * @var string
     */
    public const KEY_LATITUDE = 'latitude';

    /**
     * @var string
     */
    public const KEY_LONGITUDE = 'longitude';

    /** ********************************************************************************************* **/

    /** ********************************************************************************************* **/

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

    /** ********************************************************************************************* **/

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

    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/

    private string $name1;

    protected function getName1(): string
    {
        return $this->name1;
    }

    protected function setName1(string $name1): self
    {
        $this->name1 = \trim($name1);
        return $this;
    }

    private ?string $name2 = null;

    protected function getName2(): ?string
    {
        return $this->name2;
    }

    protected function setName2(?string $name2)
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
        return array_filter($names, static function(?string $name) {
            return !empty($name);
        });
    }

    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/

    protected ?string $fullAddress = null;

    public function getFullAddress(): string
    {
        if ($this->fullAddress === null) {
            throw new \RuntimeException('Full address is not set');
        }
        return $this->fullAddress;
    }

    protected function setFullAddress(string $fullAddress): self
    {
        $this->fullAddress = \trim($fullAddress);
        return $this;
    }

    /** ********************************************************************************************* **/

    protected ?string $street = null;

    public function getStreet(): ?string
    {
        return $this->street;
    }

    protected function setStreet(?string $street): self
    {
        $this->street = ($street !== null) ? \trim($street) : null;
        return $this;
    }

    /** ********************************************************************************************* **/

    protected ?string $zip = null;

    public function getZip(): ?string
    {
        return $this->zip;
    }

    protected function setZip(?string $zip): self
    {
        $this->zip = ($zip !== null) ? \trim($zip) : null;
        return $this;
    }

    /** ********************************************************************************************* **/

    protected ?string $city = null;

    public function getCity(): ?string
    {
        return $this->city;
    }

    protected function setCity(?string $city): self
    {
        $this->city = ($city !== null) ? \trim($city) : null;
        return $this;
    }

    /** ********************************************************************************************* **/

    protected ?string $county = null;

    public function getCounty(): ?string
    {
        return $this->county;
    }

    protected function setCounty(?string $county): self
    {
        $this->county = ($county !== null) ? \trim($county) : null;
        return $this;
    }

    /** ********************************************************************************************* **/

    /**
     * Street address' country field.
     *
     * NOTE: value is always stored lower cased.
     */
    protected ?string $country = null;

    public function getCountry(): ?string
    {
        return $this->country;
    }

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
        return array_filter($result, static function($value) {
            return !empty($value);
        });
    }

    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/

    protected ?string $phone = null;

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    protected function setPhone(?string $phone): self
    {
        $this->phone = ($phone !== null) ? \trim($phone) : null;
        return $this;
    }

    protected ?string $email = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    protected function setEmail(?string $email): self
    {
        $this->email = ($email !== null) ? \trim($email) : null;
        return $this;
    }


    /**
     * Helper methods that groups all pickup point contact types into single array.
     *
     * @return string[]
     */
    public function getContacts(): array
    {
        return [
            static::KEY_PHONE => $this->getPhone(),
            static::KEY_EMAIL => $this->getEmail(),
        ];
    }

    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/

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

    /** ********************************************************************************************* **/

    protected ?string $mondayHours = null;

    public function getMondayHours(): ?string
    {
        return $this->mondayHours;
    }

    protected function setMondayHours(?string $mondayHours): self
    {
        $this->mondayHours = $this->sanitizeHours($mondayHours);
        return $this;
    }

    protected ?string $mondayBreak = null;

    public function getMondayBreak(): ?string
    {
        return $this->mondayBreak;
    }

    protected function setMondayBreak(?string $mondayBreak): self
    {
        $this->mondayBreak = $this->sanitizeHours($mondayBreak);
        return $this;
    }

    protected ?string $tuesdayHours = null;

    public function getTuesdayHours(): ?string
    {
        return $this->tuesdayHours;
    }

    protected function setTuesdayHours(?string $tuesdayHours): self
    {
        $this->tuesdayHours = $this->sanitizeHours($tuesdayHours);
        return $this;
    }

    protected ?string $tuesdayBreak = null;

    public function getTuesdayBreak(): ?string
    {
        return $this->tuesdayBreak;
    }

    protected function setTuesdayBreak(?string $tuesdayBreak): self
    {
        $this->tuesdayBreak = $this->sanitizeHours($tuesdayBreak);
        return $this;
    }

    protected ?string $wednesdayHours = null;

    public function getWednesdayHours(): ?string
    {
        return $this->wednesdayHours;
    }

    protected function setWednesdayHours(?string $wednesdayHours): self
    {
        $this->wednesdayHours = $this->sanitizeHours($wednesdayHours);
        return $this;
    }

    protected ?string $wednesdayBreak = null;

    public function getWednesdayBreak(): ?string
    {
        return $this->wednesdayBreak;
    }

    protected function setWednesdayBreak(?string $wednesdayBreak): self
    {
        $this->wednesdayBreak = $this->sanitizeHours($wednesdayBreak);
        return $this;
    }


    protected ?string $thursdayHours = null;

    public function getThursdayHours(): ?string
    {
        return $this->thursdayHours;
    }

    protected function setThursdayHours(?string $thursdayHours): self
    {
        $this->thursdayHours = $this->sanitizeHours($thursdayHours);
        return $this;
    }

    protected ?string $thursdayBreak = null;

    public function getThursdayBreak(): ?string
    {
        return $this->thursdayBreak;
    }

    protected function setThursdayBreak(?string $thursdayBreak): self
    {
        $this->thursdayBreak = $this->sanitizeHours($thursdayBreak);
        return $this;
    }

    protected ?string $fridayHours = null;

    public function getFridayHours(): ?string
    {
        return $this->fridayHours;
    }

    protected function setFridayHours(?string $fridayHours): self
    {
        $this->fridayHours = $this->sanitizeHours($fridayHours);
        return $this;
    }

    protected ?string $fridayBreak = null;

    public function getFridayBreak(): ?string
    {
        return $this->fridayBreak;
    }

    protected function setFridayBreak(?string $fridayBreak): self
    {
        $this->fridayBreak = $this->sanitizeHours($fridayBreak);
        return $this;
    }

    protected ?string $saturdayHours = null;

    public function getSaturdayHours(): ?string
    {
        return $this->saturdayHours;
    }

    protected function setSaturdayHours(?string $saturdayHours): self
    {
        $this->saturdayHours = $this->sanitizeHours($saturdayHours);
        return $this;
    }

    protected ?string $saturdayBreak = null;

    public function getSaturdayBreak(): ?string
    {
        return $this->saturdayBreak;
    }

    protected function setSaturdayBreak(?string $saturdayBreak): self
    {
        $this->saturdayBreak = $this->sanitizeHours($saturdayBreak);
        return $this;
    }

    protected ?string $sundayHours = null;

    public function getSundayHours(): ?string
    {
        return $this->sundayHours;
    }

    protected function setSundayHours(?string $sundayHours): self
    {
        $this->sundayHours = $this->sanitizeHours($sundayHours);
        return $this;
    }

    protected ?string $sundayBreak = null;

    public function getSundayBreak(): ?string
    {
        return $this->sundayBreak;
    }

    protected function setSundayBreak(?string $sundayBreak): self
    {
        $this->sundayBreak = $this->sanitizeHours($sundayBreak);
        return $this;
    }

    public function getHours(): array
    {
        $hours = [
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
        return array_filter($hours, static function($item) {
            return $item[ static::KEY_HOURS ] !== null;
        });
    }

    /** ********************************************************************************************* **/

    protected ?string $latitude = null;

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    protected ?string $longitude = null;

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

    protected function setLocation(?string $latitude, ?string $longitude): self
    {
        if (\is_string($latitude) && \trim($latitude) === '') {
            $latitude = null;
        }
        if (\is_string($longitude) && \trim($longitude) === '') {
            $longitude = null;
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
        return $this;
    }

    /** ********************************************************************************************* **/

    protected ?string $notes = null;

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    protected function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/
    /** ********************************************************************************************* **/

    protected function __construct(string $spedition)
    {
        // dummy
    }

    /** ********************************************************************************************* **/

    public static function fromApiResponse(array $a): self
    {
        $pp = (new static())
            ->setSpeditionId($a[ static::KEY_ID ])
            ->setSpedition($a[ static::KEY_SPEDITION ]);

        if (\array_key_exists(static::KEY_GROUP_NAME, $a)) {
            $pp->setName1($a[ static::KEY_GROUP_NAME ][0]);
            if (isset($a[ static::KEY_GROUP_NAME ][1])) {
                $pp->setName2($a[ static::KEY_GROUP_NAME ][1]);
            }
        }

        if (\array_key_exists(static::KEY_GROUP_ADDRESS, $a)) {
            $pp
                ->setFullAddress($a[ static::KEY_FULL_ADDRESS ])
                ->setStreet($a[ static::KEY_STREET ])
                ->setZip($a[ static::KEY_ZIP ])
                ->setCity($a[ static::KEY_CITY ])
                ->setCounty($a[ static::KEY_COUNTY ])
                ->setCountry($a[ static::KEY_COUNTRY ]);
        }

        if (\array_key_exists(static::KEY_GROUP_CONTACTS, $a)) {
            $node = $a[ static::KEY_GROUP_CONTACTS ];
            if (\array_key_exists(static::KEY_PHONE, $node)) {
                $pp->setPhone($node[ static::KEY_PHONE ]);
            }
            if (\array_key_exists(static::KEY_EMAIL, $node)) {
                $pp->setEmail($node[ static::KEY_EMAIL ]);
            }
        }

        if (\array_key_exists(static::KEY_GROUP_HOURS, $a)) {
            $node = $a[ static::KEY_GROUP_HOURS ];

            if (\array_key_exists(static::KEY_MONDAY, $node)) {
                $pp->setMondayHours($node[ static::KEY_HOURS ]);
                $pp->setMondayBreak($node[ static::KEY_BREAK ]);
            }
            if (\array_key_exists(static::KEY_TUESDAY, $node)) {
                $pp->setTuesdayHours($node[ static::KEY_HOURS ]);
                $pp->setTuesdayBreak($node[ static::KEY_BREAK ]);
            }
            if (\array_key_exists(static::KEY_WEDNESDAY, $node)) {
                $pp->setWednesdayHours($node[ static::KEY_HOURS ]);
                $pp->setWednesdayBreak($node[ static::KEY_BREAK ]);
            }
            if (\array_key_exists(static::KEY_THURSDAY, $node)) {
                $pp->setThursdayHours($node[ static::KEY_HOURS ]);
                $pp->setThursdayBreak($node[ static::KEY_BREAK ]);
            }
            if (\array_key_exists(static::KEY_FRIDAY, $node)) {
                $pp->setFridayHours($node[ static::KEY_HOURS ]);
                $pp->setFridayBreak($node[ static::KEY_BREAK ]);
            }
            if (\array_key_exists(static::KEY_SATURDAY, $node)) {
                $pp->setSaturdayHours($node[ static::KEY_HOURS ]);
                $pp->setSaturdayBreak($node[ static::KEY_BREAK ]);
            }
            if (\array_key_exists(static::KEY_SUNDAY, $node)) {
                $pp->setSundayHours($node[ static::KEY_HOURS ]);
                $pp->setSundayBreak($node[ static::KEY_BREAK ]);
            }
        }

        if (\array_key_exists(static::KEY_GROUP_LOCATION, $a)) {
            $node = $a[ static::KEY_GROUP_LOCATION ];
            $pp->setLocation(
                $node[ static::KEY_LATITUDE ],
                $node[ static::KEY_LONGITUDE ]
            );
        }

        return $pp;
    }

} // end of class
