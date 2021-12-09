# pickup-points-api-client

A PickupPoint API Client PHP library

## Requirements

* PHP.7.4+

## Installation

```bash
$ composer require develart-projects/pickup-points-api-client
```

## Usage

**NOTE:** It is assumed that each class that tries to use API client also contains
all the required `use` clauses.

```php
use OlzaLogistic\PpApi\Client as PpApiClient;
```


Get instance of API client first:

```php
$client = PpApiClient::getInstance($accessToken);
```

Assuming you got internet access, and your `$accessToken` is correct and valid you should now be
able to access the API data.

## Client methods

* `find(string  $countryCode, ?string $spedition = null, ?string $city = null): Result;`
* `details(string $countryCode, string $spedition, string $id): Result;`
