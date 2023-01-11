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
use DNAPayments\Util\RequestException;
use Exception;
use Guzzle\Http\ClientInterface;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * @method RequestInterface authorize(array $options = array())
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface capture(array $options = array())
 * @method RequestInterface void(array $options = array())
 * @method RequestInterface createCard(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 * @method RequestInterface deleteCard(array $options = array())
 * @method RequestInterface completePurchase(array $options = array())
 */
class Gateway extends AbstractGateway
{

    /** @var DNAPayments */
    protected $dnaPayments;

    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        //set up DNAPayments config.
        $this->dnaPayments = new DNAPayments([
            'isTestMode' => true,
            'scopes' => [
                'allowHosted' => true
            ],
            'autoRedirectDelayInMs' => "10"
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
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest|PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        //get authentication
        $request = $this->createRequest(AuthRequest::class, $parameters);
        /** @var AuthResponse $response */
        $response = $request->send();

        //redirection for payment
        $parameters['auth'] = $response->getData();
        $request = $this->createRequest(CheckoutUrlRequest::class, $parameters);
        /** @var CheckoutUrlResponse $response */
        $response = $request->send();

        $parameters['checkoutUrl'] = $response->getCheckoutUrl();

        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest|CompletePurchaseRequest
     */
    public function acceptNotification(array $parameters = [])
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|RefundRequest
     */
    public function refund(array $options = [])
    {

    }
}
