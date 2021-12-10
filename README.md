# pickup-points-api-client

A PickupPoint API Client PHP library. It is HTTP client agnostic library and it will work with
any [PSR-7](https://www.php-fig.org/psr/psr-7/) compatible HTTP client,
incl. [Guzzle](https://guzzlephp.org/).

## Requirements

* PHP.7.4+
* Any PSR-7 compatible HTTP Client library (e.g. [Guzzle](https://guzzlephp.org/))

## Installation

Instal the PickupPoint API client library first

```bash
$ composer require develart-projects/pickup-points-api-client
```

then install HTTP client library of your choice, i.e. Guzzle:

```bash
$ composer require guzzlehttp/guzzle
```

## Usage

**NOTE:** It is assumed that each class that tries to use API client also contains all the
required `use` clauses.

```php
use OlzaLogistic\PpApi\Client as PpApiClient;
```

Get instance of API client first:

```php
$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withGuzzleClient()
                       ->get();
```

Assuming you got internet access, you know `$apiUrl` and your `$accessToken` is correct and valid
you should now be able to access the API data:

```php
$client = PpApiClient::useApi($url)
                       ->withAccessToken($token)
                       ->withGuzzleClient()
                       ->get();
$result = $client->find('cz');
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
    foreach( $items as $item ) {
        echo $item->getSpeditionId() . PHP_EOL;
    }
}

```

## API request methods

* `find(string $countryCode, ?string $spedition = null, ?string $city = null): Result;`
* `details(string $countryCode, string $spedition, string $id): Result;`
