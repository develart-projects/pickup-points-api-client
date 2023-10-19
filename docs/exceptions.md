![Olza Logistic Logo](olza-logo-small.png)

---

# PP API Client for PHP

* [Library requirements](requirements.md)
* [Installation](installation.md)
* [Public API methods](api.md)
* [Library classes reference](classes.md)
* **Exceptions**

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
