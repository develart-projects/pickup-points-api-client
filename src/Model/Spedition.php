<?php

namespace OlzaLogistic\PpApi\Client\Model;

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
    /* ****************************************************************************************** */
    /* ****************************************************************************************** */

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

    protected string $code;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /* ****************************************************************************************** */

    protected string $label;

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /* ****************************************************************************************** */

    protected array $names = [];

    public function getNames(): array
    {
        return $this->names;
    }

    public function addName(string $languageCode, string $name): self
    {
        $this->names[ $languageCode ] = $name;
        return $this;
    }

    public function addNames(array $names): self
    {
        foreach ($names as $languageCode => $name) {
            $this->addName($languageCode, $name);
        }
        return $this;
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
    /** @var string */
    public const KEY_CODE = 'code';
    /** @var string */
    public const KEY_LABEL = 'label';
    /** @var string */
    public const KEY_NAMES = 'names';

    public static function fromApiResponse(array $a): self
    {
        return (new static())
            ->setCode($a[ static::KEY_CODE ])
            ->setLabel($a[ static::KEY_LABEL ])
            ->addNames($a[ static::KEY_NAMES ]);

        // TODO: parse translated names
    }

} // end of class
