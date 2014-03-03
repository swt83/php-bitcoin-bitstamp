# Bitstamp

A PHP library for working w/ the Bitstamp API.

## Install

Normal install via Composer.

## Usage

Call the desired method and pass the params as a single array.

```php
$response = Travis\Bitstamp::ticker();
```

See [Bitstamp](https://www.bitstamp.net/api/) for full list of available methods.

### Private Methods

Some methods require authentication.  You are required to submit, at minimum, the ``key``, ``nonce``, and ``signature`` values.

```php
$id = 'your_account_id';
$key = 'your_api_key';
$secret = 'your_api_secret_key';
$nonce = Bitstamp::nonce();

$response = Travis\Bitstamp::balance(array(
    'key' => $key,
    'nonce' => $nonce,
    'signature' => Travis\Bitstamp::sign($id, $key, $secret, $nonce),
    // ... any other arguments ...
));
```

This library contains helper methods ``nonce()`` and ``sign()`` to aid in generating the signature.