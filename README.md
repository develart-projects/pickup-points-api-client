![Olza Logistic Logo](img/olza-logo.png)

# pickup-points-api-client

Olza Logistic's Pickup Point API Client PHP library.

---

It is HTTP client agnostic library, and it will work with
any [PSR-7](https://www.php-fig.org/psr/psr-7/) compatible HTTP client,
incl. [Guzzle](https://guzzlephp.org/).

## Requirements

* PHP 7.4+ or newer,
* Any PSR-7 compatible HTTP Client library (e.g. [Guzzle](https://guzzlephp.org/),
  [Symfony's HTTP Client](https://symfony.com/doc/current/http_client.html), etc.).

---

## Installation

Install the PickupPoint API client package first:

```bash
$ composer require develart-projects/pickup-points-api-client
```

Next, install PSR compatible HTTP client library of your choice.

### Guzzle HTTP Client

```bash
$ composer require guzzlehttp/guzzle
```

### Symfony HTTP Client

```bash
composer require symfony/http-client nyholm/psr7
```

---

## Usage

To simplify library usage, all public methods exposed by the library are expecting arguments to be
handed with use of `Params` class. All the response data is also returned wrapped in unified
`Result` class object.

* [`Client` class](#client-class)
  * [Public API methods](#public-api-methods)
* [`Params` class - passing methods arguments](#passing-methods-arguments)
* [`ApiResponse` class - response data](#consuming-response-data)
* [`Data` class - accessing response payload](#accessing-response-payload)

---

## Client class

The `Client` class is your gateway to PP API. It is a wrapper around the HTTP client library
that deals with all the struggle talking to the API and processing responses. To start using
the library you need to create instance of `Client` first:

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

Assuming you got internet access, you know `$url` and your `$accessToken` is correct and valid you
should now be able to access the API data. As API methods may require some arguments, we will need
instance of `Params` class that let us pass all these required information to the method:

```php
$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withGuzzleHttpClient()
                       ->throwOnError()
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

Note the `throwOnError()` method invoked. If you prefer exceptions not to be thrown when
API replied with failure response, you can do remove that method:

```php
$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withGuzzleHttpClient()
                       ->throwOnError()
                       ->build();

$params = Params::create()
                  ->withCountry(Country::CZECH_REPUBLIC);
$result = $client->config($params);
if($result->success()) {
  $configItems = $result->getData();
  ...
} else {
  echo "Oops, error code #{$result->getCode()}: {$result->getMessage()} . PHP_EOL;
}
```

---

### Public API methods

The following public methods serve as you gateway to PP API:

#### `config(Params $params): Result;`

Returns current vital information about PP API environment.

> **NOTE:** It's highly recommended to invoke `config/` method as your very first method during your
> PP API communication session. This method is expected to return vital runtime parameters back to
> the client so you can act accordingly. For example, `config/` will return list of all currently
> available speditions (and their IDs) so you can know in advance what to expect from other,
> spedition dependent methods.

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

* `country` - **(required)** country code (use Country::xxx consts)
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

Looks for available pickup points matching provided parameters.

Required arguments:

* `country` - **[required]** country code (use Country::xxx consts)
* `spedition` - **[required]** one (string) or more (array of strings)
* `search` - (optional) search string that will be additionally matched against pickup point names,
  identifiers, addresses, etc.
* `services` - (optional) list of services (see `ServiceType::*`) that given pickup point must
  support to be included in returned dataset. **NOTE: services are `OR`ed, so supporting just one
  suffices.**
* `payments` - (optional) list of payment types (see `PaymentType::*`) that given pickup point
  must support to be included in returned dataset. **NOTE: payment types are `OR`ed, so supporting
  just one suffices.**
* `limit` - (optional) max number of items to be returned. Default is to return all matching items.

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

Looks for pickup points located nearby specified geographic location.

* `country` - **[required]** country code (use Country::xxx consts)
* `spedition` - **[required]** one (string) or more (array of strings)
* `coords` - **[required]** search string that will be additionally matched against pickup point
  names, identifiers, addresses, etc.

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

---

### Passing methods arguments

All public client methods requiring arguments expect instance of `Params` class as argument, with
all the method required arguments set using all exposed `withXXX()` helper methods. For
example, `find()` methods expects `country` and `spedition` arguments, so create `Params`
instance first using `create()` static method and set the params:

```php
$params = Params::create()
          ->withCountry($country)
          ->withSpedition($spedition);
```

then you pass it to the client method:

```php
$response = $client->find($params);
```

`Params` class exposes the following public methods:

```php
public static function create(): self
```

Create empty instance of Params class. That should be the your starting point for most of the cases.

```php
public function throwOnError(): self
```

By default all public API methods called always returned `Result` object. To see if command
succeded or not, you need to call `success()` method on the returned object and then branch your
code logic accordingly. This can lead to ugly and less readable code, so alternatively, you can
order the client to always throw the `MethodFailedException` instead.

```php
public function withCountry(string $country): self
```

Sets country code (use Country::xxx consts) to use with the request.

```php
public function withCity(string $city): self
```

Sets spedition code to be used with the request (use Spedition::xxx codes)

```php
public function withSpedition(string $spedition): self
```

Id of the element (mainly Pickup Point) as returned by the API (i.e. from /find)

```php
public function withSpeditionId(string $speditionId): self
```

Sets location to be sent with the request.

```php
public function withLocation(?float $latitude, ?float $longitude): self
```

Sets `fields` arguments (array of FieldType::xxx).

```php
public function withFields(?array $fields): self
```

Adds given field type (FieldType::xxx) to the list of requested fields.

```php
public function addField(string $field): self
```

// Sets API access token to be used. Set automatically by the client library. public function

```php
withAccessToken(string $accessToken): self
```

## Result class

Client response are always handed as instance of `Result` class. The object is inmutable, and for
ease of use, `Result` is subclass
of [ArrayObject](https://www.php.net/manual/en/class.arrayobject.php) and aside from exposing useful
methods also acts as regular array:

```php
...
$result = $client->find('cz');
$items = $result->getData();
foreach($items as $item) {
    echo $item->getSpeditionId() . PHP_EOL;
}
...
```

`Result` class exposes the following public methods:

```php
public function success(): bool
```

Returns boolean indicating API response status.

```php
public function getCode(): int
```

Gets API returned status code associated with the response (this is not a HTTP status code).

```php
public function getMessage(): ?string
```

Returns API returned status message string.

```php
public function getData(): ?Data
```

Returns API returned payload.

### Data class methods

```php
public function getItems(): ?array
```

Some endpoints return list of items (i.e. list of Pickup Points). In such case you can obtain the
list of items using `getItems()` method on `Data` class instance.


---

### Accessing response payload

Most methods return additional data back as as additional payload. The structure may differ per
method, yet all the methods return the payload the same way via instance of `Data` class embedded
in `Result` object:

```php
$params = Params::create()
                  ->withCountry(Country::CZECH_REPUBLIC)
                  ->withSpedition(Spedition::PACKETA_IPP);
$result = $client->find($params);

/*
 * It's safe not to check for `null` as we always get the `Data` object no matter we got any
 * matching Pickup Point or not. In case of no data you will get empty Data instance.
 */
$items = $result->getData();
foreach($items as $pp) {
    echo $pp->getSpeditionId() . PHP_EOL;
}
...
```
