<?php

namespace DigiTickets\OmnipayOptomanyCheckout\Message;

use DNAPayments\DNAPayments;

class CheckoutUrlRequest extends AbstractRequest
{
    /**
     * @return array
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount');
        $this->validate('notifyUrl');

        $card = $this->getCard();

        $data = [];
        $data['postLink'] = $this->getNotifyUrl();
        $data['failurePostLink'] = $this->getNotifyUrl();
        $data['backLink'] = $this->getReturnUrl();
        $data['failureBackLink'] = $this->getCancelUrl();
        $data['description'] = $this->getDescription();
        $data['terminal'] = $this->getTerminal();
        $data['invoiceId'] = $this->getTransactionId();
        $data['currency'] = $this->getCurrency();
        $data['amount'] = $this->getAmount();
        $data['accountId'] = 'accountId';
        $data['accountCountry'] = $card->getCountry();
        $data['accountCity'] = $card->getCity();
        $data['accountStreet1'] = $card->getAddress1();
        $data['accountEmail'] = $card->getEmail();
        $data['accountFirstName'] = $card->getFirstName();
        $data['accountLastName'] = $card->getLastName();
        $data['accountPostalCode'] = $card->getPostcode();
        $data['phone'] = $card->getBillingPhone();
        $data['language'] = 'EN';

        return $data;
    }

    /**
     * @param mixed $data The data to send
     *
     * @return CheckoutUrlResponse
     */
    public function sendData($data)
    {
        $response['url'] = DNAPayments::generateUrl($data, $this->getAuth());

        return $this->response = new CheckoutUrlResponse($this, $response);
    }
}
