<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Test;

use DigiTickets\OmnipayOptomanyCheckout\Message\AuthRequest;
use DigiTickets\OmnipayOptomanyCheckout\Message\AuthResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class AuthResponseTest extends TestCase
{
    public function testGetAccessToken()
    {
        $request = Mockery::mock(AuthRequest::class);
        $data = [
            'access_token' => 'testtoken',
        ];

        $purchaseResponse = new AuthResponse($request, $data);

        $this->assertTrue($purchaseResponse->isSuccessful());
        $this->assertFalse($purchaseResponse->isRedirect());
        $this->assertEquals('testtoken', $purchaseResponse->getAccessToken());
    }

    public function testNoAccessToken()
    {
        $request = Mockery::mock(AuthRequest::class);
        $data = [
            'access_token' => '',
        ];

        $purchaseResponse = new AuthResponse($request, $data);

        $this->assertFalse($purchaseResponse->isSuccessful());
    }
}
