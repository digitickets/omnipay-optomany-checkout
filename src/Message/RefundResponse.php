<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use Omnipay\Common\Message\AbstractResponse;

class RefundResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return !empty($this->data['success']);
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
