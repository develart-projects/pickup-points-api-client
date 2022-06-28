<?php

/**
 * Find nearby PPs
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

$lat = 50.087;
$long = 14.421;
$params = Params::create()
                  ->withCountry(Country::CZECHIA)
                  ->withSpedition(Spedition::PACKETA_IPP)
                  ->withLocation($lat, $long);

$apiResponse = $client->nearby($params);

echo '<pre>';
print_r($apiResponse);
echo '</pre>';





