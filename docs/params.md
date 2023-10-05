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

## Passing methods arguments

All public client methods requiring arguments expect instance of `Params` class as argument, with
all the method required arguments set using all exposed `withXXX()` helper methods. For
example, `find()` methods expects `country` and `spedition` arguments, so create `Params`
instance first using `create()` static method and set the params:

```php
$params = Params::create()
          ->withCountry($country)
          ->withSpedition($spedition);
```

then you pass it to the client method:

```php
$response = $client->find($params);
```

`Params` class exposes the following public methods:

```php
public static function create(): self
```

Create empty instance of Params class. That should be the your starting point for most of the cases.

```php
public function throwOnError(): self
```

By default, all public API methods return a `Result` object when called. To determine if the command
succeeded or not, you need to call the `success()` method on the returned object and then branch
your code logic accordingly. This approach can lead to less readable code, so alternatively, you can
instruct the client to always throw a `MethodFailedException` instead.

```php
public function withCountry(string $country): self
```

Sets country code (use Country::xxx consts) to use with the request.

```php
public function withCity(string $city): self
```

Sets spedition code to be used with the request (use Spedition::xxx codes)

```php
public function withSpedition(string $spedition): self
```

Id of the element (mainly Pickup Point) as returned by the API (i.e. from /find)

```php
public function withSpeditionId(string $speditionId): self
```

Sets location to be sent with the request.

```php
public function withLocation(?float $latitude, ?float $longitude): self
```

Sets `fields` arguments (array of FieldType::xxx).

```php
public function withFields(?array $fields): self
```

Adds given field type (FieldType::xxx) to the list of requested fields.

```php
public function addField(string $field): self
```

Sets API access token to be used.

```php
public function withAccessToken(string $accessToken): self
```
