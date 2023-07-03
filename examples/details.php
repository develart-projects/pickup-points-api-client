<?php
declare(strict_types=1);

/*
 * PP Detail
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
                  ->withSpedition(Spedition::PACKETA_IPP)
                  ->withSpeditionId('135');

$apiResponse = $client->details($params);

echo '<pre>';
print_r($apiResponse);
echo '</pre>';
