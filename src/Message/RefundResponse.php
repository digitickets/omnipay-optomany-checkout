<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use Omnipay\Common\Message\AbstractResponse;

class RefundResponse extends AbstractResponse
{
    const TRANSACTION_STATES = [
        'AUTH',
        'FAILED',
        'REJECT',
        'CHARGE',
    ];

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data['success']) && ($this->data['success'] == true);
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->data['id'] ?? '';
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->data['message'] ?? '';
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->data['code'] ?? '';
    }
}
