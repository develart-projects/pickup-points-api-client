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

## Requirements

The PP API Client library has the following requirements:

- PHP 7.4 or newer.
- One HTTP client library to handle HTTP requests and responses.
- PSR-17 HTTP Factory library to create request/response objects, stream objects, and URI objects.

Though various HTTP clients are supported, only one is required to make the library functional. The
choice of HTTP client can be based on the specific needs of your project. Aside from the solid
implementations provided, any future HTTP client adhering to the PSR standards will also be
supported out of the box.

#### HTTP Clients

The library supports the following HTTP clients:

- Guzzle (version 7.4 or newer)
- Symfony HttpClient (version 5.4 or newer)
- Any PSR-18 compatible HTTP client

### Installation

The library can be easily installed via Composer, a dependency manager for PHP.

1. If you don't have Composer installed, begin by [downloading it](https://getcomposer.org/).
2. Once Composer is installed, you can install the PP API Client library by running the following
   command in your project's root directory:

```bash
composer require develart-projects/pickup-points-api-client
```

This command will download the PP API Client library and its core dependencies. Next, you need to
install one of the supported HTTP clients (unless you have it installed already).
For example, to install Guzzle, run the following command:

```bash
composer require guzzlehttp/guzzle
```

To install Symfony HttpClient, run the following command:

```bash
composer require symfony/http-client
```

With these steps, you are now ready to use the PP API Client library in your project. Remember, you
only need to install one HTTP client. Choose the one that best fits your project's needs.
