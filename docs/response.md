![Olza Logistic Logo](olza-logo-small.png)

---

# PP API Client for PHP

* [Library requirements](requirements.md)
* [Installation](installation.md)
* [Public API methods](api.md)
* Library API reference

* [Library classes reference](classes.md)
  * [`Client` class - gateway to the PP API](client.md)
  * [`Params` - passing method arguments](params.md)
  * `Result` - accessing response data

---

## Accessing response data

Client responses are always provided as instances of the `Result` class. The object is immutable,
and for ease of use, `Result` is a subclass
of [ArrayObject](https://www.php.net/manual/en/class.arrayobject.php). Aside from exposing useful
methods, it also acts as a regular array:

```php
$result = $client->find('cz');
$items = $result->getData();
foreach($items as $item) {
    echo $item->getSpeditionId() . PHP_EOL;
}
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
The expected values are:

* `ApiCode::ERROR_OBJECT_NOT_FOUND` (`100`): API rejects the request due to invalid credentials (
  like invalid or outdated access token)
* `ApiCode::ERROR_ACCESS_DENIED` (`101`): API rejects the request due to invalid credentials (like
  invalid or outdated access token).

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
use OlzaLogistic\PpApi\Client\Params;
use OlzaLogistic\PpApi\Client\Model\Country;
use OlzaLogistic\PpApi\Client\Model\Spedition;


$params = Params::create()
                  ->withCountry(Country::CZECHIA)
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
