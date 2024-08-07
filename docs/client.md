![Olza Logistic Logo](olza-logo-small.png)

---

# PP API Client for PHP

* [Library requirements](requirements.md)
* [Installation](installation.md)
* [Public API methods](api.md)
* [Library classes reference](classes.md)
  * `Client` - gateway to the PP API
    * [Usage](#usage)
    * [Creating client instance](#creating-client-instance)
      * [Using with Guzzle library](#using-with-guzzle-library)
      * [Using with Symfony HTTP Client)](#using-with-symfony-http-client)
  * [`Params` - passing method arguments](params.md)
  * [`Result` - accessing response data](response.md)
  * [Exceptions](exceptions.md)

---

## Usage

The `Client` class serves as your gateway to the PP API. It acts as a wrapper around the HTTP client
library, handling the intricacies of communicating with the API and processing responses.

To simplify the usage of the library, all public methods provided by the library expect arguments to
be passed using the `Params` class. All response data is also returned, encapsulated within a
unified `Result` class object. For those who prefer handling exceptions rather than checking the
result, there's a mode that transforms each unsuccessful API response into a corresponding
exception (for more information, see the details on `Client` class instantiation).

## Creating client instance

To begin using the library, you need to first create an instance of the `Client` class, using
static `public static function useApi(string $apiUrl)` method and several builder methods:

| Method signature                                              | Description                                                                                           |
|---------------------------------------------------------------|-------------------------------------------------------------------------------------------------------|
| `withAccessToken(string $accessToken)`                        | Configures the client to utilize a specific access token when interacting with the Pickup Points API. |
| `withUserAgent(string $userAgent)`                            | Specifies the User-Agent string for all HTTP API requests.                                            |
| `withHttpClient(ClientInterface $httpClient)`                 | Configures a PSR-18 compatible instance of an HTTP client implementation.                             |
| `withRequestFactory(requestFactoryInterface $requestFactory)` | Configures a PSR-17 compatible request factory instance to work with the HTTP client.                 |
| `withStreamFactory(streamFactoryInterface $streamFactory)`    | Configures a PSR-17 compatible stream factory instance to work with the HTTP client.                  |
| `throwOnError()`                                              | Configures the client to throw an exception in case of any API connection failure.                    |

NOTE: the `StreamFactoryInterface` instance is usually not needed. Unless you use methods
explicitly documented as requiring a stream factory, you can safely ignore it and not provide it.

Then calling `build()` to obrain the `Client` instance:

```php
use OlzaLogistic\PpApi\Client\Client as PpApiClient;

$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withHttpClient($httpClient)
                       ->withRequestFactory($requestFactory)
                       ->throwOnError()
                       ->build();
```

Assuming you have internet access, and your `$url` and `$accessToken` are correct and valid, you
should now be able to access the API data. As API methods may require certain arguments, you will
need an instance of the `Params` class to pass all the required information to the method:

```php
use OlzaLogistic\PpApi\Client\Client as PpApiClient;
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Model\Country;

$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withHttpClient($httpClient)
                       ->withRequestFactory($requestFactory)
                       ->build();

$params = Params::create()
                  ->withCountry(Country::CZECHIA);
$result = $client->config($params);
if($result->success()) {
  $configItems = $result->getData();
  ...
} else {
  echo "Oops, error code #{$result->getCode()}: {$result->getMessage()}" . PHP_EOL;
}
```

Once successfully executed, the `$configItems` shall contain current vital information about PP API
environment.

![Note](note.png) If you prefer an "exception-driven" application control flow, you can achieve this
by calling the `throwOnError()` method during client instantiation. This causes the client to throw
an exception for any kind of failure, including HTTP errors and invalid responses. This also covers
error-indicating API responses (e.g., a request for a non-existing PP will return a valid response,
yet the response will contain an error code and message for your request, triggering an exception to
be thrown):

```php
$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withHttpClient($httpClient)
                       ->withRequestFactory($requestFactory)
                       ->throwOnError()  // <-- any error will end up as an exception
                       ->build();

try {
  $params = Params::create()
                    ->withCountry(Country::CZECHIA);
  $result = $client->find($params);
  ...
} catch (MethodFailedException $ex) {
  ...
}
```

![Note](note.png) Most of the examples in this documentation use the "exception-driven" approach,
therefore you will not see the code checking the `success()` method on the `Result` object, however
you are free to use either approach as you see fit.

### Using with Guzzle library

To use the this library with Guzzle, ensure you install both the HTTP client and PSR-7 compatible
request library:

```bash
composer require guzzlehttp/guzzle guzzlehttp/psr7
```

Then, create an instance of the `Client` class:

```php
$httpClient = new \GuzzleHttp\Client();
$requestFactory = new \GuzzleHttp\Psr7\HttpFactory();

$client = PpApiClient::useApi($url)
                     ->withAccessToken($token)
                     ->withHttpClient($httpClient)
                     ->withRequestFactory($requestFactory)
                     ->build();
```

### Using with Symfony HTTP Client

Unless you are trying to use this library from i.e. existing Symfony framework based project, you
need to install the Symfony HTTP client package and any package implementing PSR-17 request factory,
l.e. [nyholm/psr7](https://packagist.org/packages/nyholm/psr7):

```bash
composer require symfony/http-client nyholm/psr7
```

Then, create an instance of the `Client` class:

```php
$httpClient = new \Symfony\Component\HttpClient\Psr18Client();
$requestFactory = new \Nyholm\Psr7\Factory\Psr17Factory();

$client = PpApiClient::useApi($url)
                     ->withAccessToken($token)
                     ->withHttpClient($httpClient)
                     ->withRequestFactory($requestFactory)
                     ->build();
```
