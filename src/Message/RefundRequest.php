<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use DNAPayments\DNAPayments;

class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        return [
            'id' => $this->getTransactionReference(),
            'amount' => $this->getAmount(),
        ];
    }

    public function sendData($data)
    {
        $response = $this->getDnaPaymentsInstance()->refund($data);

        return $this->response = new RefundResponse($this, $response);
    }

    public function setDnaPaymentsInstance(DNAPayments $instance)
    {
        $this->setParameter('dnaPaymentsInstance', $instance);
    }

    /**
     * @return DNAPayments|null
     */
    public function getDnaPaymentsInstance()
    {
        return $this->getParameter('dnaPaymentsInstance');
    }
}
