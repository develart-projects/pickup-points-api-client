![Olza Logistic Logo](../img/olza-logo.png)

# pickup-points-api-client

## Usage

To simplify library usage, all public methods exposed by the library are expecting arguments to be
handed with use of `Params` class. All the response data is also returned wrapped in unified
`Result` class object.

* [`Client` class](api.md#client-class)
* [Public API methods](api.md#public-api-methods)
  * [`config(Params $params): Result;`](api.md#configparams-params-result)
  * [`details(Params $params): Result;`](api.md#detailsparams-params-result)
  * [`find(Params $params): Result;`](api.md#findparams-params-result)
  * [`search(Params $params): Result;`](api.md#searchparams-params-result)
* [`Params` class - passing methods arguments](params.md#passing-methods-arguments)
* [`Result` class - accessing response data](#response.md#accessing-response-data)
* [`Data` class - accessing response payload](response.md#accessing-response-payload)
