![Olza Logistic Logo](olza-logo-small.png)

---

# PP API Client for PHP

* Library requirements]
* [Installation](installation.md)
* [Public API methods](api.md)
* [Library classes reference](classes.md)

---

## Requirements

The PP API Client library has the following requirements:

* PHP 7.2 or newer.
* [PSR-18](https://www.php-fig.org/psr/psr-18/) compatible HTTP client library to handle HTTP
  requests and responses.
* [PSR-17](https://www.php-fig.org/psr/psr-17/) compatible HTTP Factory library to create
  request/response objects, stream objects, and URI objects

![Note](note.png) Though various HTTP clients are supported, only one is required to make the
library functional. The choice of HTTP client can be based on the specific needs of your project.
Aside from the solid implementations provided, any future HTTP client adhering to the PSR standards
will also be supported out of the box. Most of the most popular libraries (like i.e. Guzzle or
Symfony client already support PSR-18 and PSR-17 and can be used with the library. See the
documentation for usage examples).
