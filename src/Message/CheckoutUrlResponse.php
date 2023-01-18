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

        $json = $this->getData();

        return $json['url'];
    }


    /**
     * @return bool
     */
    public function isSuccessful()
    {
        $json = $this->getData();

        return $json &&
            is_array($json) &&
            !empty($json['url']);
    }
}
