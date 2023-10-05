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

## Accessing response data

Client responses are always provided as instances of the `Result` class. The object is immutable,
and for ease of use, `Result` is a subclass
of [ArrayObject](https://www.php.net/manual/en/class.arrayobject.php). Aside from exposing useful
methods, it also acts as a regular array:

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

Some endpoints return a list of items (e.g., a list of Pickup Points). In such cases, you can obtain
the list of items using the `getItems()` method on the `Data` class instance.

### Accessing response payload

Most methods return additional data as an additional payload. The structure may vary per method, yet
all methods return the payload in the same manner via an instance of the `Data` class embedded in
the `Result` object:

```php
$params = Params::create()
                  ->withCountry(Country::CZECH_REPUBLIC)
                  ->withSpedition(Spedition::PACKETA_IPP);
$result = $client->find($params);

/*
 * It's safe to omit a `null` check as we always receive a `Data` object, regardless of whether
 * we have any matching Pickup Points or not. In the case of no data, you will receive an empty
 * `Data` instance.
 */
$items = $result->getData();
foreach($items as $pp) {
    echo $pp->getSpeditionId() . PHP_EOL;
}
...
```
