![Olza Logistic Logo](../olza-logo-small.png)

---

# PP API Client for PHP

**[« Go back to main ToC](../README.md)**

* [Library requirements](../requirements.md)
* [Installation](../installation.md)
* [Public API methods](../api.md)
* [Library classes reference](../classes.md)
* Usage examples
  * [Obtaing API configuration](config.md)
  * [Searching for pickup points](find.md)
  * Retrieving pickup point details
  * [Finding nearby pickup points](nearby.md)

---

## Retrieving pickup point details

```php
use OlzaLogistic\PpApi\Client\Client as PpApiClient;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Model\Country;
use OlzaLogistic\PpApi\Client\Model\Spedition;

$apiToken = '<YOUR REAL PP API TOKEN>';
$apiUrl = 'https://...';

// Using Guzzle HTTP client
$httpClient = \GuzzleHttp\Client();
$requestFactory = \GuzzleHttp\Psr7\RequestFactory();

$client = PpApiClient::useApi($apiUrl)
                     ->withAccessToken($apiToken)
                     ->withHttpClient($httpClient)
                     ->withRequestFactory($requestFactory)
                     ->throwOnError()
                     ->build();

$params = Params::create()
                  ->withCountry(Country::CZECHIA)
                  ->withSpedition(Spedition::PACKETA_IPP)
                  ->withSpeditionId('135');

$apiResponse = $client->details($params);

print_r($apiResponse);
```
