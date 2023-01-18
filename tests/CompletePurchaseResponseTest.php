<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Test;

use DigiTickets\OmnipayOptomanyCheckout\Message\CompletePurchaseRequest;
use DigiTickets\OmnipayOptomanyCheckout\Message\CompletePurchaseResponse;
use Mockery;
use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    /**
     * @dataProvider creationProvider
     */
    public function testCreatingCompletePurchaseResponse(
        array $data,
        bool $expectedSuccess,
        bool $expectedCancelled,
        string $expectedReference = null
    ) {
        $request = Mockery::mock(CompletePurchaseRequest::class);

        $response = new CompletePurchaseResponse($request, $data);

        $this->assertEquals($expectedSuccess, $response->isSuccessful());
        $this->assertEquals($expectedCancelled, $response->isCancelled());
        $this->assertEquals($expectedReference, $response->getTransactionReference());
    }

    /**
     * @return array
     */
    public function creationProvider()
    {
        return [
            'success' => [
                ['id' => '123', 'success' => true],
                true,
                false,
                '123',
            ],
            'declined' => [
                ['id' => '', 'success' => false],
                false,
                true,
                null,
            ],
        ];
    }
}
