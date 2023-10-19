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

The library supports the following HTTP clients:
  * Any `PSR-18` compatible HTTP client and `PSR-17` compatible request factory.
  * Symfony HttpClient (version 5.4 or newer)


This command will download the PP API Client library and its core dependencies. Next, you need to
install one of the supported HTTP clients (unless you have it installed already).
For example, to install Guzzle, run the following command:

```bash
composer require guzzlehttp/guzzle guzzlehttp/psr7
```

To install Symfony HTTP client, run the following command:

```bash
composer require symfony/http-client
```

With these steps, you are now ready to use the PP API Client library in your project. Remember, you
only need to install one HTTP client. Choose the one that best fits your project's needs.
