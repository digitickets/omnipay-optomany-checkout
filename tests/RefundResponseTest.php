<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Test;

use DigiTickets\OmnipayOptomanyCheckout\Message\RefundRequest;
use DigiTickets\OmnipayOptomanyCheckout\Message\RefundResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class RefundResponseTest extends TestCase
{
    /**
     * @dataProvider creationProvider
     */
    public function testCreatingRefund(
        array $data,
        bool $expectedSuccess,
        string $expectedMessage,
        string $transactionRef
    ) {
        $request = Mockery::mock(RefundRequest::class);

        $purchaseResponse = new RefundResponse($request, $data);

        $this->assertEquals($expectedSuccess, $purchaseResponse->isSuccessful());
        $this->assertEquals($expectedMessage, $purchaseResponse->getMessage());
        $this->assertEquals($transactionRef, $purchaseResponse->getTransactionReference());
    }

    /**
     * @return array
     */
    public function creationProvider()
    {
        return [
            'success' => [
                ['id' => '123', 'success' => true, 'message' => 'success'],
                true,
                'success',
                '123',
            ],
            'failed' => [
                ['id' => '123', 'success' => false, 'message' => 'failed'],
                false,
                'failed',
                '123',
            ],
        ];
    }
}
