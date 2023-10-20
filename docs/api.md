![Olza Logistic Logo](olza-logo-small.png)

---

# PP API Client for PHP

* [Library requirements](requirements.md)
* [Installation](installation.md)
* Public API methods
  * [`config(Params $params): Result;`](#configparams-params-result)
  * [`details(Params $params): Result;`](#detailsparams-params-result)
  * [`find(Params $params): Result;`](#findparams-params-result)
  * [`nearby(Params $params): Result;`](#nearbyparams-params-result)
* [Library classes reference](classes.md)

---

## Usage

To simplify the usage of the library, all public methods provided by the library expect arguments to
be passed using the [Params](params.md) class. All response data is also returned, encapsulated
within a unified [Result](response.md) class object. For those who prefer handling exceptions rather
than checking the result, there's a mode that transforms each unsuccessful API response into a
corresponding exception (for more information, see the details
on [Client class instantiation](client.md)).

---

## Public API methods

The following public methods serve as you gateway to PP API:

### `config(Params $params): Result;`

Returns current vital information about PP API environment.

![Note](note.png)  It's highly recommended to invoke the `config/` method as the very first method
during your PP API communication session. This method is expected to return vital runtime parameters
back to the client, allowing you to act accordingly. For instance, `config/` will return a list of
all currently available carriers (and their IDs), providing foresight on what to expect from other
carrier-dependent methods.

Required arguments:

* `country` - **(required)** country code (use `Country::xxx` consts)

[See usage example](examples/config.md)

---

### `details(Params $params): Result;`

Return details about specific Pickup Point.

Required arguments:

* `country` - **(required)** country code (use `Country::xxx` consts)
* `spedition` - **(required)** one (string) or more (array of strings)
* `id` - **(required)** Pickup point identifier

[See usage example](examples/details.md)

---

### `find(Params $params): Result;`

Searches for available pickup points that match the provided parameters.

Required arguments:

* `country` - **[required]** country code (use `Country::xxx` consts).
* `spedition` - **[required]** either a single spedition (string) or multiple speditions (array of
  strings).

Optional arguments:

* `search` - A search string that will be additionally matched against pickup point names,
  identifiers, addresses, etc.
* `services` - A list of services (see `ServiceType::*`) that a pickup point must support to be
  included in the returned dataset. **NOTE: services are `OR`ed, so supporting just one suffices.**
* `payments` - A list of payment types (see `PaymentType::*`) that a pickup point must support to be
  included in the returned dataset. **NOTE: payment types are `OR`ed, so supporting just one
  suffices.**
* `limit` - The maximum number of items to be returned. The default is to return all matching items
  (API cap limit may apply).

[See usage example](examples/find.md)

---

### `nearby(Params $params): Result;`

Searches for pickup points located near a specified geographic location.

Required arguments:

* `country` - **[required]** country code (use `Country::xxx` consts).
* `spedition` - **[required]** either a single spedition (string) or multiple speditions (array of
  strings).
* `coords` - **[required]** geographic coordinates to search near. The value should be a string in
  the format `latitude,longitude`.
* `limit` - The maximum number of items to be returned. The default is to return all matching
  items (API cap limit may apply).

[See usage example](examples/nearby.md)
