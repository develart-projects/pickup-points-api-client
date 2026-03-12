![Olza Logistic Logo](olza-logo-small.png)

---

# PP API Client for PHP

* [Library requirements](requirements.md)
* [Installation](installation.md)
* [Public API methods](api.md)
* [Library classes reference](classes.md)
  * [`Client` - gateway to the PP API](client.md)
  * `Params` - passing method arguments
  * [`Result` - accessing response data](response.md)
  * [Exceptions](exceptions.md)

---

## Passing methods arguments

All public client methods requiring arguments expect instance of `Params` class as argument, with
all the method required arguments set using all exposed `withXXX()` helper methods. For
example, `find()` methods expects `country` and `spedition` arguments, so create `Params`
instance first using `create()` static method and set the params:

```php
use OlzaLogistic\PpApi\Client\Params;

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
public function withCountry(string $country): self
```

Sets country code (use Country::xxx consts) to use with the request.

```php
public function withCity(string $city): self
```

Sets city name to be used with the request.

```php
public function withSpedition(string $spedition): self
```

Sets spedition code to be used with the request (use Spedition::xxx codes).

```php
public function withSpeditions(array $speditions): self
```

Sets multiple spedition codes at once (array of Spedition::xxx codes).

```php
public function withSpeditionId(string $speditionId): self
```

Sets spedition ID to be sent with the request.

```php
public function withLocation(?float $latitude, ?float $longitude): self
```

Sets location to be sent with the request.

```php
public function withLimit(int $limit): self
```

Sets the maximum number of items to be returned by the API.

```php
public function withFields(?array $fields): self
```

Sets `fields` arguments (array of FieldType::xxx).

```php
public function addField(string $field): self
```

Adds given field type (FieldType::xxx) to the list of requested fields.

```php
public function withAccessToken(string $accessToken): self
```

Sets API access token to be used.
