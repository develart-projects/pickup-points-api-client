![Olza Logistic Logo](../img/olza-logo.png)

# pickup-points-api-client

* [`Client` class](api.md#client-class)
* [Public API methods](api.md#public-api-methods)
    * [`config(Params $params): Result;`](api.md#configparams-params-result)
    * [`details(Params $params): Result;`](api.md#detailsparams-params-result)
    * [`find(Params $params): Result;`](api.md#findparams-params-result)
    * [`search(Params $params): Result;`](api.md#searchparams-params-result)
* [`Params` class - passing methods arguments](params.md#passing-methods-arguments)
* [`Result` class - accessing response data](#response.mdaccessing-response-data)
* [`Data` class - accessing response payload](response.md#accessing-response-payload)

## Accessing response data

Client response are always handed as instance of `Result` class. The object is inmutable, and for
ease of use, `Result` is subclass
of [ArrayObject](https://www.php.net/manual/en/class.arrayobject.php) and aside from exposing useful
methods also acts as regular array:

```php
...
$result = $client->find('cz');
$items = $result->getData();
foreach($items as $item) {
    echo $item->getSpeditionId() . PHP_EOL;
}
...
```

`Result` class exposes the following public methods:

```php
public function success(): bool
```

Returns boolean indicating API response status.

```php
public function getCode(): int
```

Gets API returned status code associated with the response (this is not a HTTP status code).

```php
public function getMessage(): ?string
```

Returns API returned status message string.

```php
public function getData(): ?Data
```

Returns API returned payload.

### Data class methods

```php
public function getItems(): ?array
```

Some endpoints return list of items (i.e. list of Pickup Points). In such case you can obtain the
list of items using `getItems()` method on `Data` class instance.

### Accessing response payload

Most methods return additional data back as as additional payload. The structure may differ per
method, yet all the methods return the payload the same way via instance of `Data` class embedded
in `Result` object:

```php
$params = Params::create()
                  ->withCountry(Country::CZECH_REPUBLIC)
                  ->withSpedition(Spedition::PACKETA_IPP);
$result = $client->find($params);

/*
 * It's safe not to check for `null` as we always get the `Data` object no matter we got any
 * matching Pickup Point or not. In case of no data you will get empty Data instance.
 */
$items = $result->getData();
foreach($items as $pp) {
    echo $pp->getSpeditionId() . PHP_EOL;
}
...
```
