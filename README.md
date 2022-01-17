# pickup-points-api-client

A PickupPoint API Client PHP library. It is HTTP client agnostic library, and it will work with
any [PSR-7](https://www.php-fig.org/psr/psr-7/) compatible HTTP client,
incl. [Guzzle](https://guzzlephp.org/).

## Requirements

* PHP 7.2+,
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

## Usage

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

Assuming you got internet access, you know `$url` and your `$accessToken` is correct and valid
you should now be able to access the API data. As API methods may require some arguments, we will
need instance of `Params` class that let us pass all these required information to the method:

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

## Result class

Client response are always returned with use of `Response` class.

**TODO:** Response class docs!

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

## API request methods

* `details(string $countryCode, string $spedition, string $id): Result;`
* `find(string $countryCode, ?string $spedition = null, ?string $city = null): Result;`
* `nearby(string $countryCode, string $location): Result;`
