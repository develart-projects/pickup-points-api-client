<?php

namespace OlzaLogistic\PpApi\Client\Model;

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
class Spedition
{
    /**
     * @var string
     */
    public const CZECH_POST = 'CP-BAL';

    /**
     * @var string
     */
    public const GLS = 'GLS-PS';

    /**
     * @var string
     */
    public const PPL = 'PPL-PS';

    /**
     * @var string
     */
    public const SLOVAK_POST = 'SP-BOX';

    /**
     * @var string
     */
    public const SPS = 'SPS-PP';

    /**
     * @var string
     */
    public const WEDO = 'BMCG-INT-PP';

    /**
     * Hungarian Post: Parcel Terminal (Parcel Box)
     *
     * @var string
     */
    public const HUNGARIAN_POST_PARCEL_BOX = 'HUP-CS';

    /**
     * Hungarian Post: Post Office, shops, gas station etc
     *
     * @var string
     */
    public const HUNGARIAN_POST_OTHERS = 'HUP-PP';

    /* ****************************************************************************************** */

    /**
     * Country code of the spedition.
     */
    protected string $country;

    public function getCountry(): string
    {
        return $this->country;
    }

    protected function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Code of the spedition (i.e. 'CP-BAL' for 'Ceska Posta').
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected string $spedition;

    public function getSpedition(): string
    {
        return $this->spedition;
    }

    public function setSpedition(string $spedition): self
    {
        $this->spedition = $spedition;
        return $this;
    }

    /**
     * If set to FALSE, the spedition is not reported as available.
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected bool $isEnabled = false;

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    /* ****************************************************************************************** */
    /* ****************************************************************************************** */
    /* ****************************************************************************************** */

    protected function __construct()
    {
        // dummy
    }

    /* ****************************************************************************************** */

    /** @var string */
    public const KEY_COUNTRY = 'country';
    /** @var string */
    public const KEY_SPEDITION = 'spedition';

    public static function fromApiResponse(array $a): self
    {
        return (new static())
            ->setCountry($a[ static::KEY_COUNTRY ])
            ->setSpedition($a[ static::KEY_SPEDITION ]);
    }

} // end of class
