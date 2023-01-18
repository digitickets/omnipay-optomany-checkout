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

        if (!$this->validateSignature($postData, $this->getClientSecret())) {
            throw new \Exception("Invalid signature");
        }

        if ($this->getTransactionId() != $postData['invoiceId']) {
            throw new \Exception("The order does not match the invoiceId.");
        }

        return $this->response = new CompletePurchaseResponse($this, $postData);
    }

    /**
     * @param array $data
     * @param string $clientSecret
     *
     * @return bool
     */
    public function validateSignature(array $data, string $clientSecret)
    {
        if (empty($clientSecret)) {
            throw new \Exception("Missing client secret");
        }

        $message =
            $data['id'].
            $data['amount'].
            $data['currency'].
            $data['invoiceId'].
            $data['errorCode'].
            $data['success'];
        $calculatedSignature = hash_hmac('sha256', $message, $clientSecret);
        if (!$calculatedSignature === $data['signature']) {
            return false;
        }

        return true;
    }
}
