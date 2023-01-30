# omnipay-optomany-checkout

**Redirect gateway driver for Optomany's Checkout hosted service**

Omnipay implementation of Optomany's Checkout hosted gateway.

See [Optomany's Checkout documentation](https://developer.dnapayments.com/docs/payment-page/) for more details.

Also [Checkout PHP SDK Integration Guide](https://developer.dnapayments.com/docs/ecommerce/checkout/integration-guide/php) for php integration

## Installation

This driver is installed via [Composer](http://getcomposer.org/). To install, simply add it to your `composer.json` file:

```json
{
  "require": {
    "digitickets/omnipay-optomany-checkout": "^1.0"
  }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## What's Included

This driver allows you to redirect the user to an Optomany Checkout page, after passing in customer details from your own forms and a redirect URL. Once the user has paid they will be redirected back to your redirect page. You can then await the webhook that confirms the payment.

It also supports refunds of partial and full amounts. The documentation says only one refund can be made against the transaction ID, but in testing multiple partial refunds seem to go through fine.

It requires use of 3DSecure v2.

## What's Not Included

This driver does not support subscriptions (repeat payments).

## Basic Usage

For general Omnipay usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

### Required Parameters

You must pass the following parameters into the driver when calling `purchase()`, `refund()` or `acceptNotification()`:

```
clientId: Given to you when signing up with Optomany
clientSecret: Given to you when signing up with Optomany
terminal: Given to you when signing up with Optomany
```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you believe you have found a bug in this driver, please report it using the [GitHub issue tracker](https://github.com/digitickets/omnipay-optomany-checkout/issues), or better yet, fork the library and submit a pull request.
