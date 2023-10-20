![Olza Logistic Logo](olza-logo-small.png)

---

# PP API Client for PHP

* [Library requirements](requirements.md)
* [Installation](installation.md)
* [Public API methods](api.md)
* [Library classes reference](classes.md)

---

## Installation

The library can be easily installed via Composer, a dependency manager for PHP.

1. If you don't have Composer installed, begin by [downloading it](https://getcomposer.org/).
2. Once Composer is installed, you can install the PP API Client library by running the following
   command in your project's root directory:

```bash
composer require develart-projects/pickup-points-api-client
```

### HTTP Clients

The library supports any `PSR-18` compatible HTTP client and `PSR-17` compatible request factory,

See [Client class documentation](client.md) or [usage examples](examples/) now how to use library
with various HTTP clients.
