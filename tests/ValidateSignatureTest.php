<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Test;

use DigiTickets\OmnipayOptomanyCheckout\Message\CompletePurchaseRequest;
use Guzzle\Http\ClientInterface;
use Mockery;
use Omnipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ValidateSignatureTest extends TestCase
{
    public function testValidSignature()
    {
        $httpClient = Mockery::mock(ClientInterface::class);
        $httpRequest = Mockery::mock(Request::class);

        $purchaseRequest = new CompletePurchaseRequest($httpClient, $httpRequest);
        $json =
            '{"id": "c52aa9e0-9296-47f0-86ed-d6a9e90a48cc",
              "rrn": "d9721c46-a360-4ed9-93b4-02c0a0d74395",
              "paymentMethod": "card",
              "amount": 0.01,
              "currency": "GBP",
              "invoiceId": "abc1234567",
              "accountId": "uuid000001",
              "errorCode": 0,
              "success": true}';
        $data = json_decode($json, true);

        $clientSecret = 'testtesttest';
        $message = 'c52aa9e0-9296-47f0-86ed-d6a9e90a48cc0.01GBPabc12345670true';
        $signature = hash_hmac('sha256',$message, $clientSecret);
        $data['signature'] = $signature;

        $this->assertTrue($purchaseRequest->validateSignature($data, $clientSecret));
    }

    public function testInvalidSignature()
    {
        $httpClient = Mockery::mock(ClientInterface::class);
        $httpRequest = Mockery::mock(Request::class);
        $purchaseRequest = new CompletePurchaseRequest($httpClient, $httpRequest);

        $json =
            '{"id": "c52aa9e0-9296-47f0-86ed-d6a9e90a48cc",
              "rrn": "d9721c46-a360-4ed9-93b4-02c0a0d74395",
              "paymentMethod": "card",
              "amount": 9.99,
              "currency": "GBP",
              "invoiceId": "abc1234567",
              "accountId": "uuid000001",
              "errorCode": 0,
              "success": true}';
        $data = json_decode($json, true);

        $clientSecret = 'testtesttest';
        $message = 'badmessage';
        $signature = hash_hmac('sha256',$message, $clientSecret);
        print_r($signature);
        $data['signature'] = $signature;

        $this->assertTrue( $purchaseRequest->validateSignature($data, $clientSecret));
    }
}
