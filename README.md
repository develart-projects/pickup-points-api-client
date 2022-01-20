# pickup-points-api-client

A PickupPoint API Client PHP library. It is HTTP client agnostic library, and it will work with
any [PSR-7](https://www.php-fig.org/psr/psr-7/) compatible HTTP client,
incl. [Guzzle](https://guzzlephp.org/).

## Requirements

* PHP 7.4+ or PHP 8.x (or newer),
* Any PSR-7 compatible HTTP Client library (e.g. [Guzzle](https://guzzlephp.org/),
  [Symfony's HTTP Client](https://symfony.com/doc/current/http_client.html), etc.).

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

### Symfony PSR18 HTTP Client

```bash
composer require symfony/http-client nyholm/psr7
```

---

## Usage

To simplify library usage, all public methods exposed by the library are expecting arguments to be
handed with use of `Params` class and all the response data is returned wrapped in `Result` class
instance.

### Params - passing methods arguments

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

Create empty instance of Params class

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
if ($result->success()) {
    $items = $result->getData();
    foreach($items as $item) {
        echo $item->getSpeditionId() . PHP_EOL;
    }
}
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

### Examples

**NOTE:** It is assumed that each class that tries to use API client also contains all the
required `use` clauses to import required symbols:

```php
use OlzaLogistic\PpApi\Client as PpApiClient;
use OlzaLogistic\PpApi\Client\Country;
```

Get instance of API client first:

```php
$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withGuzzleHttpClient()
                       ->build();
```

Assuming you got internet access, you know `$url` and your `$accessToken` is correct and valid you
should now be able to access the API data. As API methods may require some arguments, we will need
instance of `Params` class that let us pass all these required information to the method:

```php
$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withGuzzleHttpClient()
                       ->get();
$params = Params::create()
                  ->withCountry(Country::CZECH);
$result = $client->find($params);
...
```

## Client methods

### `find(Params $params): Result;`

Looks for available pickup points. 

Required arguments:
* country - country code (use Country::xxx consts)
* spedition - one (string) or more (array of strings)

### `details(Params $params): Result;`
### `nearby(Params $params): Result;`
### `speditions(Params $params): Result;`
