<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use DNAPayments\DNAPayments;

class AuthRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        $data = [
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'terminal' => $this->getTerminal(),
            'invoiceId' => $this->getTransactionId(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
        ];

        return array_filter($data);
    }

    /**
     * @param mixed $data The data to send
     *
     * @return AuthResponse
     */
    public function sendData($data)
    {
        $response = DNAPayments::auth($data);

        return $this->response = new AuthResponse($this, $response);
    }
}
