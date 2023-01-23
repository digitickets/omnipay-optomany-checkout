<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use DNAPayments\DNAPayments;
use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = [];

        return $data;
    }

    public function sendData($data)
    {
        $postJson = file_get_contents('php://input');

        $postData = empty($data) ? json_decode($postJson, true) : $data;

        if (empty($postData)) {
            throw new InvalidRequestException('No data in callback');
        }

        if (!DNAPayments::isValidSignature($postData, $this->getClientSecret())) {
            throw new InvalidRequestException('Invalid signature');
        }

        if (empty($postData['invoiceId']) || ($this->getTransactionId() != $postData['invoiceId'])) {
            throw new InvalidRequestException('The order does not match the invoiceId.');
        }

        return $this->response = new CompletePurchaseResponse($this, $postData);
    }
}
