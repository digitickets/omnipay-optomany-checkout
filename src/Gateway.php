<?php

namespace DigiTickets\OmnipayOptomanyCheckout;

use DigiTickets\OmnipayOptomanyCheckout\Message\AuthRequest;
use DigiTickets\OmnipayOptomanyCheckout\Message\AuthResponse;
use DigiTickets\OmnipayOptomanyCheckout\Message\CheckoutUrlRequest;
use DigiTickets\OmnipayOptomanyCheckout\Message\CheckoutUrlResponse;
use DigiTickets\OmnipayOptomanyCheckout\Message\CompletePurchaseRequest;
use DigiTickets\OmnipayOptomanyCheckout\Message\PurchaseRequest;
use DigiTickets\OmnipayOptomanyCheckout\Message\RefundRequest;
use DNAPayments\DNAPayments;
use Guzzle\Http\ClientInterface;
use Omnipay\Common\AbstractGateway;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class Gateway extends AbstractGateway
{
    /** @var DNAPayments */
    protected $dnaPayments;

    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        // set up DNAPayments config.
        $this->dnaPayments = new DNAPayments([
            'scopes' => [
                'allowHosted' => true,
            ],
        ]);
        parent::__construct($httpClient, $httpRequest);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'OptomanyCheckout';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [];
    }

    /**
     * @return \Omnipay\Common\Message\AbstractRequest|PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        // set dnaPayments testMode
        $this->dnaPayments::configure(['isTestMode' => $this->getTestMode()]);

        // get authentication
        $request = $this->createRequest(AuthRequest::class, $parameters);
        /** @var AuthResponse $response */
        $response = $request->send();

        // redirection for payment
        $parameters['auth'] = $response->getData();
        $request = $this->createRequest(CheckoutUrlRequest::class, $parameters);
        /** @var CheckoutUrlResponse $response */
        $response = $request->send();

        $parameters['checkoutUrl'] = $response->getCheckoutUrl();

        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @return \Omnipay\Common\Message\AbstractRequest|CompletePurchaseRequest
     */
    public function acceptNotification(array $parameters = [])
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @return \Omnipay\Common\Message\AbstractRequest|RefundRequest
     */
    public function refund(array $options = [])
    {
        // set dnaPayments testMode from parameters
        $this->dnaPayments::configure(['isTestMode' => $this->getTestMode()]);

        $options['dnaPaymentsInstance'] = $this->dnaPayments;

        return $this->createRequest(RefundRequest::class, $options);
    }
}
