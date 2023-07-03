<?php
declare(strict_types=1);

/**
 * Configuration for given country
 */

// Setup autoloading
include '../vendor/autoload.php';

use OlzaLogistic\PpApi\Client\Client as PpApiClient;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Model\Country;


// YOUR TESTING CREDENTIALS AND SETTINGS
$apiToken = 'XYZ';
$apiUrl = 'https://...';
// TESTING SECTION END

$client = PpApiClient::useApi($apiUrl)
                       ->withAccessToken($apiToken)
                       ->withGuzzleHttpClient()
                       ->build();

$params = Params::create()
                  ->withCountry(Country::CZECHIA);

$apiResponse = $client->config($params);

echo '<pre>';
print_r($apiResponse);
echo '</pre>';
