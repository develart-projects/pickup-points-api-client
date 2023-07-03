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

See [detailed documentation](docs/README.md) for more information about the library, its methods
and usage examples.

## License ##

* Copyright &copy;2011-2023 by DevelArt, s.r.o.
* This is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
