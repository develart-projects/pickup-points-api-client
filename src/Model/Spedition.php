<?php
declare(strict_types=1);

/**
 * Olza Logistic's Pickup Points API client
 *
 * @author    Marcin Orlowski <marcin.orlowski (#) develart (.) cz>
 * @copyright 2021-2023 DevelArt
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/develart-projects/pickup-points-api-client/
 */
namespace OlzaLogistic\PpApi\Client\Model;

class Spedition
{
    public const COLETARIA                 = 'zas-col';
    public const CZECH_POST                = 'cp-bal';
    public const GLS                       = 'gls-ps';
    public const HUNGARIAN_POST_OFFICE     = 'hup-pm';
    public const HUNGARIAN_POST_OTHERS     = 'hup-pp';
    public const HUNGARIAN_POST_PARCEL_BOX = 'hup-cs';
    public const INPOST                    = 'bmcg-ipkp';
    public const OMNIVA                    = 'omni-pm';
    public const PACKETA_EPP_ACS_BOX       = 'zas-acs-pp';
    public const PACKETA_EPP_ECONT_BOX     = 'zas-econt-box';
    public const PACKETA_EPP_ECONT_PP      = 'zas-econt-pp';
    public const PACKETA_EPP_SPEEDY_PP     = 'zas-speedy-pp';
    public const PACKETA_IPP               = 'zas';
    public const PPL                       = 'ppl-ps';
    public const SAEB_BOX                  = 'zas-saeb';
    public const SLOVAK_POST               = 'sp-box';
    public const SPS                       = 'sps-ps';
    public const VENIPAK                   = 'venip-pp';
    public const WEDO                      = 'bmcg-int-pp';

    /* ****************************************************************************************** */
    /* ****************************************************************************************** */
    /* ****************************************************************************************** */

    /**
     * Code (identifier) of the spedition.
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

    /**
     * Returns TRUE if spedition is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    /* ****************************************************************************************** */

    protected string $code;

    /**
     * Returns spedition's code (identifier).
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Sets spedition's code (identifier).
     *
     * @param string $code
     *
     * @return Spedition
     */
    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /* ****************************************************************************************** */

    protected string $label;

    /**
     * Returns spedition's label (name).
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Sets spedition's label (name).
     *
     * @param string $label
     *
     * @return Spedition
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /* ****************************************************************************************** */

    protected array $names = [];

    /**
     * Returns spedition's names in all supported languages.
     *
     * @return array<string, string>
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * Adds single translated spedition name.
     *
     * @param string $languageCode Language code for the $name string
     * @param string $name         Translated name
     */
    public function addName(string $languageCode, string $name): self
    {
        $this->names[$languageCode] = $name;
        return $this;
    }

    /**
     * Add new names to spedition's name list.
     *
     * @param array<string, string> $names Names to be added.
     */
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

    /**
     * NOTE: intentionally protected.
     */
    final protected function __construct() {}

    /* ****************************************************************************************** */

    public const KEY_COUNTRY   = 'country';
    public const KEY_SPEDITION = 'spedition';
    public const KEY_CODE      = 'code';
    public const KEY_LABEL     = 'label';
    public const KEY_NAMES     = 'names';

    /**
     * Returns instance of Spedition, instantiated using data from provided source array.
     *
     * @param array $spedData Spedition data from API response.
     */
    public static function fromApiResponse(array $spedData): self
    {
        $spedition = new static();

        if (\array_key_exists(static::KEY_CODE, $spedData)) {
            $spedition->setCode($spedData[static::KEY_CODE]);
        }
        if (\array_key_exists(static::KEY_LABEL, $spedData)) {
            $spedition->setLabel($spedData[static::KEY_LABEL]);
        }
        if (\array_key_exists(static::KEY_NAMES, $spedData)) {
            $spedition->addNames($spedData[static::KEY_NAMES]);
        }

        return $spedition;
    }

} // end of class
