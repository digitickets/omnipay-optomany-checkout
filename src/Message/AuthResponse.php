<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use DNAPayments\DNAPayments;
use Omnipay\Common\Message\AbstractResponse;

class AuthResponse extends AbstractResponse
{
    /**
     * @return string|null
     */
    public function getAccessToken()
    {
        $json = $this->getData();

        return $json['access_token'] ?? null;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        $json = $this->getData();

        return $json && is_array($json) && !empty($json['access_token']);
    }

}
