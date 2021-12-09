<?php

namespace Develart\PpApi\Client\Contracts;

use Develart\PpApi\Client\Result;

interface ClientContract
{
    /**
     * @param string      $countryCode
     * @param string|null $spedition
     * @param string|null $town
     */
    public function find(string  $countryCode, ?string $spedition = null,
                         ?string $city = null): Result;

    public function details(string $countryCode, string $spedition, string $id): Result;

}
