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
  * [Exceptions](exceptions.md)

---

## Exceptions

The library throws exceptions of the following classes (all exceptions are in the
`\OlzaLogistic\PpApi\Client\Exception` namespace):

* `InvalidResponseStructureException` is thrown when the
  response from the API is malformed (i.e. missing required fields, or having invalid values).

When [`Client` object](client.md) is instantiated with `throwOnError()` option set, the following
exceptions will be thrown on API errors:

* `AccessDeniedException` - thrown when the API rejects the request due to invalid credentials (like
  invalid or outdated access token).
* `ObjectNotFoundException` - thrown when requested data was not found (i.e. invalid PP reference
  ID, or invalid carrier ID etc.).
