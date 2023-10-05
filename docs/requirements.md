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
- HTTP client library to handle HTTP requests and responses.
- PSR-17 HTTP Factory library to create request/response objects, stream objects, and URI objects.

![Note](note.png) Though various HTTP clients are supported, only one is required to make the library functional. The
choice of HTTP client can be based on the specific needs of your project. Aside from the solid
implementations provided, any future HTTP client adhering to the PSR standards will also be
supported out of the box.

#### HTTP Clients

The library directly supports and was tested with the following HTTP clients:

- Guzzle (version 7.4 or newer)
- Symfony HttpClient (version 5.4 or newer)

It also supports
[PSR compatible HTTP clients](https://packagist.org/providers/psr/http-client-implementation)
