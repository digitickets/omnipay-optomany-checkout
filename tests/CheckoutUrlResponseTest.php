<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Test;

use DigiTickets\OmnipayOptomanyCheckout\Message\CheckoutUrlRequest;
use DigiTickets\OmnipayOptomanyCheckout\Message\CheckoutUrlResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class CheckoutUrlResponseTest extends TestCase
{
    public function testCreatingCheckoutUrl()
    {
        $request = Mockery::mock(CheckoutUrlRequest::class);
        $data = [
            'url' => 'http://google.com',
        ];

        $purchaseResponse = new CheckoutUrlResponse($request, $data);

        $this->assertFalse($purchaseResponse->isSuccessful());
        $this->assertTrue($purchaseResponse->isRedirect());
        $this->assertEquals('http://google.com', $purchaseResponse->getCheckoutUrl());
    }

    public function testNotCreatingCheckoutUrl()
    {
        $request = Mockery::mock(CheckoutUrlRequest::class);
        $data = [
            'url' => '',
        ];

        $purchaseResponse = new CheckoutUrlResponse($request, $data);

        $this->assertFalse($purchaseResponse->isSuccessful());
        $this->assertFalse($purchaseResponse->isRedirect());
        $this->assertNotEquals('http://google.com', $purchaseResponse->getCheckoutUrl());
    }
}
