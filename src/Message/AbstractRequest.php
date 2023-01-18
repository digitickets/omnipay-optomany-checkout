<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest
{

    /**
     * @return string|null
     */
    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    public function setClientId(string $value)
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @return string|null
     */
    public function getClientSecret()
    {
        return $this->getParameter('clientSecret');
    }

    public function setClientSecret(string $value)
    {
        return $this->setParameter('clientSecret', $value);
    }

    /**
     * @return string|null
     */
    public function getTerminal()
    {
        return $this->getParameter('terminal');
    }

    public function setTerminal(string $value)
    {
        return $this->setParameter('terminal', $value);
    }

    /**
     * @return array|null
     */
    public function getAuth()
    {
        return $this->getParameter('auth');
    }

    public function setAuth(array $value)
    {
        return $this->setParameter('auth', $value);
    }
}
