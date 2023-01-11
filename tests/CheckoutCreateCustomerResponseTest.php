<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Test;

use DigiTickets\OmnipayOptomanyCheckout\Message\AuthRequest;
use DigiTickets\OmnipayOptomanyCheckout\Message\AuthResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class CheckoutCreateCustomerResponseTest extends TestCase
{
    public function testCreatingCustomer()
    {
        $request = Mockery::mock(AuthRequest::class);
        $data = [
            '_id' => '123',
        ];

        $purchaseResponse = new AuthResponse($request, $data);

        $this->assertTrue($purchaseResponse->isSuccessful());
        $this->assertFalse($purchaseResponse->isRedirect());
        $this->assertEquals('123', $purchaseResponse->getCustomerId());
    }
}
