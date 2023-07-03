<?php
declare(strict_types=1);

/**
 * find PPs for given country
 */

// Setup autoloading
include '../vendor/autoload.php';

use OlzaLogistic\PpApi\Client\Client as PpApiClient;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Model\Country;
use OlzaLogistic\PpApi\Client\Model\Spedition;


// YOUR TESTING CREDENTIALS AND SETTINGS
$apiToken = 'XYZ';
$apiUrl = 'https://...';
// TESTING SECTION END

$client = PpApiClient::useApi($apiUrl)
                       ->withAccessToken($apiToken)
                       ->withGuzzleHttpClient()
                       ->build();

$params = Params::create()
                  ->withCountry(Country::CZECHIA)
                  ->withSpeditions([Spedition::PACKETA_IPP, Spedition::PACKETA_EPP_SPEEDY_PP]);

$apiResponse = $client->find($params);

echo '<pre>';
print_r($apiResponse);
echo '</pre>';
