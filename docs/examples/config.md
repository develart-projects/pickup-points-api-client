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

## Getting API runtime details for given country

```php
use OlzaLogistic\PpApi\Client\Client as PpApiClient;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Model\Country;

// Configure with real URL and token
$apiToken = '<YOUR REAL PP API TOKEN>';
$apiUrl = 'https://...';

// Construct instance of API Client
// See docs for details about HTTP client and request factory
$client = PpApiClient::useApi($apiUrl)
                     ->withAccessToken($apiToken)
                     ->withHttpClient($httpClient)
                     ->withRequestFactory($requestFactory)
                     ->throwOnError()
                     ->build();

// Prepare request params
$params = Params::create()
                ->withCountry(Country::CZECHIA);

// Call API method
$apiResponse = $client->config($params);

print_r($apiResponse);
```
