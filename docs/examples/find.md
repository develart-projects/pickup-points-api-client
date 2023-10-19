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
  * Searching for pickup points
  * [Retrieving pickup point details](detail.md)
  * [Finding nearby pickup points](nearby.md)

---

## Finds Pickup Points in given country

```php
use OlzaLogistic\PpApi\Client\Client as PpApiClient;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Model\Country;
use OlzaLogistic\PpApi\Client\Model\Spedition;

// Construct instance of API Client
// See docs for details about HTTP client and request factory
$client = PpApiClient::useApi('<REAL PP API URL>')
                     ->withAccessToken('<YOUR REAL PP API TOKEN>')
                     ->withHttpClient(...)
                     ->withRequestFactory(...)
                     ->throwOnError()
                     ->build();

// Prepare request params
$params = Params::create()
                  ->withCountry(Country::CZECHIA)
                  ->withSpeditions([
                      Spedition::PACKETA_IPP,
                      Spedition::PACKETA_EPP_SPEEDY_PP,
                    ]);

// Call API method
$apiResponse = $client->find($params);

print_r($apiResponse);
```
