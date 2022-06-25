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
    public const PACKETA_IPP                 = 'zas';
    public const PACKETA_EPP_ECONT_PP        = 'zas-econt-pp';
    public const PACKETA_EPP_ECONT_BOX       = 'zas-econt-box';
    public const PACKETA_EPP_SPEEDY_PP       = 'zas-speedy-pp';
    public const PACKETA_EPP_ACS_BOX         = 'zas-acs-pp';
    public const PACKETA_EPP_SAMEDAY_EASYBOX = 'zas-saeb';

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

    final protected function __construct()
    {
        // dummy
    }

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
            $spedition->setCode($spedData[ static::KEY_CODE ]);
        }
        if (\array_key_exists(static::KEY_LABEL, $spedData)) {
            $spedition->setLabel($spedData[ static::KEY_LABEL ]);
        }
        if (\array_key_exists(static::KEY_NAMES, $spedData)) {
            $spedition->addNames($spedData[ static::KEY_NAMES ]);
        }

        return $spedition;
    }

} // end of class
