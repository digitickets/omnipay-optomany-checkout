<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use DNAPayments\DNAPayments;

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
            throw new \Exception("No data in callback");
        }

        if (!DNAPayments::isValidSignature($postData, $this->getClientSecret())) {
            throw new \Exception("Invalid signature");
        }

        if (empty($this->getTransactionId()) || ($this->getTransactionId() != $postData['invoiceId'])) {
            throw new \Exception("The order does not match the invoiceId.");
        }

        return $this->response = new CompletePurchaseResponse($this, $postData);
    }
}
