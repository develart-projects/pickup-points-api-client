![Olza Logistic Logo](olza-logo-small.png)

---

# PP API Client for PHP

* [Library requirements](requirements.md)
* [Installation](installation.md)
* [Public API methods](api.md)
* Library classes reference
* [Exceptions](exceptions.md)

---

## `Client` - gateway to PP API

The `Client` class serves as your gateway to the PP API. It acts as a wrapper around the HTTP client
library, handling the intricacies of communicating with the API and processing responses.

[`Client` class API documentation](client.md)

---

## `Params` - method arguments vessel

All public client methods requiring arguments expect instance of `Params` class as argument, with
all the method required arguments set using all exposed `withXXX()` helper methods.

[`Params` class API documentation](params.md)

---

## `Result` - response data container

Client responses are always provided as instances of the `Result` class. The object is immutable,
and for ease of use, `Result` is a subclass
of [ArrayObject](https://www.php.net/manual/en/class.arrayobject.php) and aside from exposing useful
methods, it also acts as a regular array.

[`Result` class API documentation](response.md)
