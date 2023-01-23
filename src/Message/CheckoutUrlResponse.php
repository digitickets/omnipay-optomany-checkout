<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use Omnipay\Common\Message\AbstractResponse;

class CheckoutUrlResponse extends AbstractResponse
{
    /**
     * @return string|null
     */
    public function getCheckoutUrl()
    {
        $data = $this->getData();

        return $data['url'];
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        $data = $this->getData();

        return $data &&
            is_array($data) &&
            !empty($data['url']);
    }
}
