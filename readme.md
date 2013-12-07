# Bitstamp

A PHP library for working w/ the Bitstamp API.

## Usage

Call the desired method and pass the params as a single array.

```php
$response = Travis\Bitstamp::ticker();

$response = Travis\Bitstamp::balance(array(
    'key' => 'yourapikey',
));
```

See [Bitstamp](https://www.bitstamp.net/api/) for full list of available methods.

## Todo

- Private methods don't work yet.  Will add signature stuff shortly.