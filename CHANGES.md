![Olza Logistic Logo](docs/olza-logo-small.png)

Olza Logistic's Pickup Point API Client PHP library.

---

# Changelog

* v1.4.0 (2024-07-19)
  * Added possibility of raw requests.

* v1.3.3 (2024-01-25)
  * Added `PickupPointType` class with type consts.


* v1.3.2 (2023-11-28)
  * `PickupPoint` class now implements exposes and `getType()` method.


* v1.3.1 (2023-10-31)
  * Refactored to lower PHP requirements down to 7.2+
  * Updated tests.


* v1.3.0 (2023-10-20)
  * Added `withHttpClient()` and `withRequestFactory()` methods to `Client` builder.
  * Removed `withGuzzleHttpClient()` as Guzzle no longer needs special treatment.
  * Removed `withSymfonyHttpClient()`. See docs on how to use Symfony HTTP client.
  * Removed `withPsrClient()`. Use `withHttpClient()` and `withRequestClient()` instead.
  * Attempt to modify sealed client now throws `ClientAlreadyInitializedException`.
  * Attempt to access not sealed client now throws `ClientNotSealedException`.
  * Improved construction of `Config` response object.
  * The `Spedition::getLabel()` now returns spedition code if no label is returned by API.
  * Implemented `Arrayable` contact (`toArray()`) for response data classes.
  * Updated tests.
  * Updated library documentation.


* v1.2.2 (2023-10-06)
  * Fixed API response code not being included in the thrown exception.
  * Added dedicated exceptions to reflect API error codes (when `throwOnError` is enabled).
  * Added dedicated `ApiCode` class to match API codes.
  * Added `Exceptions` chapter to documentation.
  * Renamed `ResponseIncorrectParserException` to `InvalidResponseStructureException`.


* v1.2.1 (2023-10-05)
  * Updated library documentation


* v1.2.0 (2023-06-03)
  * All files are now declaring strict types.
  * Updated code comments.
  * Updated documentation.


* v1.1.3 (2023-06-20)
  * Fixed example in the docs.


* v1.1.2 (2022-07-12)
  * Fixed PP names not initialized.


* v1.1.0
  * Changed `Country::CZECH_REPUBLIC` to `Country::CZECHIA`.
  * Added support for `payments` and `services` args of `find()`.
  * Updated library dependencies.


* v1.0.0 (2022-02-16)
  * Initial public release.
