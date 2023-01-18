<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data['success']) && ($this->data['success'] == true);
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return !empty($this->data['errorCode']) || !isset($this->data['success']) || ($this->data['success'] == false);
    }

    /**
     * @return bool
     */
    public function isPending()
    {

        return $this->isSuccessful() && isset($this->data['settled']) && ($this->data['settled'] == false);
    }

    /**
     * this is our transaction ID
     *
     * @return string|null
     */
    public function getTransactionId()
    {
        return isset($this->data['invoiceId']) ? $this->data['invoiceId'] : null;
    }

    /**
     * this is optomany's transaction ID
     *
     * @return string|null
     */
    public function getTransactionReference()
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        if (!empty($this->data['message'])) {
            return $this->data['message'];
        }

        return isset($this->data['status']) ? $this->data['status'] : null;
    }

    /**
     * @return string|null
     */
    public function getCode()
    {
        return $this->data['errorCode'] ?? null;
    }
}
