![Olza Logistic Logo](olza-logo-small.png)

---

# PP API Client for PHP

* **[« Go back](README.md)**
* [Library requirements](requirements.md)
* [Installation](installation.md)
* Library API reference
  * [`Client` class - gateway to the PP API](client.md#gateway-to-the-api)
    * [Creating client instance](client.md#instantiation)
    * Public API methods
      * [`config(Params $params): Result;`](client.md#configparams-params-result)
      * [`details(Params $params): Result;`](client.md#detailsparams-params-result)
      * [`find(Params $params): Result;`](client.md#findparams-params-result)
      * [`search(Params $params): Result;`](client.md#searchparams-params-result)
  * [`Params` class - passing method arguments](params.md#passing-method-arguments)
  * [`Result` class - accessing response data](response.md#accessing-response-data)
    * [`Data` class - accessing response payload](response.md#accessing-response-payload)

---

## Usage

To simplify the usage of the library, all public methods provided by the library expect arguments to
be passed using the `Params` class. All response data is also returned, encapsulated within a
unified `Result` class object. For those who prefer handling exceptions rather than checking the
result, there's a mode that transforms each unsuccessful API response into a corresponding
exception (for more information, see the details on `Client` class instantiation).

---

## Client class

The `Client` class serves as your gateway to the PP API. It acts as a wrapper around the HTTP client
library, handling the intricacies of communicating with the API and processing responses.

### Instantiation

To begin using the library, you need to first create an instance of the `Client` class:

```php
use OlzaLogistic\PpApi\Client\Client as PpApiClient;

$url = ...
$accessToken = ...

$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withGuzzleHttpClient()
                       ->throwOnError()
                       ->build();
```

Assuming you have internet access, and your `$url` and `$accessToken` are correct and valid, you
should now be able to access the API data. As API methods may require certain arguments, you will
need an instance of the `Params` class to pass all the required information to the method:

```php
$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withGuzzleHttpClient()
                       ->build();

$params = Params::create()
                  ->withCountry(Country::CZECH_REPUBLIC);
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
                       ->withGuzzleHttpClient()
                       ->throwOnError()  // <-- any error will end up as an exception
                       ->build();

try {
  $params = Params::create()
                    ->withCountry(Country::CZECH_REPUBLIC);
  $result = $client->find($params);
  ...
} catch (MethodFailedException $ex) {
  ...
}
```

![Note](note.png) Most of the examples in this documentation use the "exception-driven" approach,
therefore you will not see the code checking the `success()` method on the `Result` object, however
you are free to use either approach as you see fit.

---

### Public API methods

The following public methods serve as you gateway to PP API:

#### `config(Params $params): Result;`

Returns current vital information about PP API environment.

![Note](note.png)  It's highly recommended to invoke the `config/` method as the very first method
during your PP API communication session. This method is expected to return vital runtime parameters
back to the client, allowing you to act accordingly. For instance, `config/` will return a list of
all currently available carriers (and their IDs), providing foresight on what to expect from other
carrier-dependent methods.

Required arguments:

* `country` - **(required)** country code (use Country::xxx consts)

```php
$params = Params::create()
                  ->withCountry(Country::CZECH_REPUBLIC);
$result = $client->config($params);
$configItems = $result->getData();
...
...
```

#### `details(Params $params): Result;`

Return details about specific Pickup Point.

Required arguments:

* `country` - **(required)** country code (use `Country::xxx` consts)
* `spedition` - **(required)** one (string) or more (array of strings)
* `id` - **(required)** Pickup point identifier

```php
$params = Params::create()
                  ->withCountry(Country::CZECH_REPUBLIC)
                  ->withSpedition(Spedition::PACKETA_IPP)
                  ->withSpeditionId('12345');
$result = $client->details($params);
$items = $result->getData();
foreach($items as $pp) {
  echo $pp->getSpeditionId() . PHP_EOL;
}
...

...
```

#### `find(Params $params): Result;`

Searches for available pickup points that match the provided parameters.

Required arguments:

* `country` - **[required]** country code (use `Country::xxx` consts).
* `spedition` - **[required]** either a single spedition (string) or multiple speditions (array of
  strings).

Optional arguments:

* `search` - A search string that will be additionally matched against pickup point names,
  identifiers, addresses, etc.
* `services` - A list of services (see `ServiceType::*`) that a pickup point must support to be
  included in the returned dataset. **NOTE: services are `OR`ed, so supporting just one suffices.**
* `payments` - A list of payment types (see `PaymentType::*`) that a pickup point must support to be
  included in the returned dataset. **NOTE: payment types are `OR`ed, so supporting just one
  suffices.**
* `limit` - The maximum number of items to be returned. The default is to return all matching items.

```php
$params = Params::create()
                  ->withCountry(Country::CZECH_REPUBLIC)
                  ->withSpedition(Spedition::PACKETA_IPP);
$result = $client->find($params);
$items = $result->getData() ?? [];
foreach($items as $pp) {
  echo $pp->getSpeditionId() . PHP_EOL;
}
...
```

#### `nearby(Params $params): Result;`

Searches for pickup points located near a specified geographic location.

Required arguments:

* `country` - **[required]** country code (use `Country::xxx` consts).
* `spedition` - **[required]** either a single spedition (string) or multiple speditions (array of
  strings).
* `coords` - **[required]** geographic coordinates to search near. The value should be a string in
  the format `latitude,longitude`.

![Note](note.png) The `coords` argument description seems to have been copied erroneously from
the `search`
argument in the previous method. It should specify the format for providing geographic coordinates
rather than matching against pickup point attributes.

```php
$lat = 50.087;
$long = 14.421;
$params = Params::create()
                  ->withCountry(Country::CZECH_REPUBLIC)
                  ->withSpedition(Spedition::PACKETA_IPP)
                  ->withLocation($lat, $long);
$result = $client->nearby($params);
/** @var ?Data $data */
$items = $result->getData() ?? [];
foreach($items as $pp) {
  echo $pp->getSpeditionId() . PHP_EOL;
}
...
```
