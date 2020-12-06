<?php
/**
 * YooKassa driver for Omnipay payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-yoo-kassa
 * @package   omnipay-yoo-kassa
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YooKassa;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Http\ClientInterface;
use Omnipay\YooKassa\Message\CaptureRequest;
use Omnipay\YooKassa\Message\CaptureResponse;
use Omnipay\YooKassa\Message\DetailsRequest;
use Omnipay\YooKassa\Message\DetailsResponse;
use Omnipay\YooKassa\Message\IncomingNotificationRequest;
use Omnipay\YooKassa\Message\PurchaseRequest;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use YooCheckout\Client;

/**
 * Class Gateway.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class Gateway extends AbstractGateway
{
    /** @var Client|null */
    private $yooClient;

    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        parent::__construct($httpClient, $httpRequest);
    }

    protected function getYooClient(): Client
    {
        if ($this->yooClient === null) {
            $this->yooClient = new Client();
            $this->yooClient->setAuth($this->getShopId(), $this->getSecret());
        }

        return $this->yooClient;
    }

    public function getName()
    {
        return 'Yoo.Kassa';
    }

    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
    }

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    /**
     * @param array $parameters
     * @return PurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $this->injectYooClient($parameters));
    }

    /**
     * @param array $parameters
     * @return CaptureResponse|\Omnipay\Common\Message\AbstractRequest
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest(CaptureRequest::class, $this->injectYooClient($parameters));
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|DetailsRequest
     */
    public function details(array $parameters = [])
    {
        return $this->createRequest(DetailsRequest::class, $this->injectYooClient($parameters));
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|DetailsResponse
     */
    public function notification(array $parameters = [])
    {
        return $this->createRequest(IncomingNotificationRequest::class, $this->injectYooClient($parameters));
    }

    private function injectYooClient(array $parameters): array
    {
        $parameters['yooClient'] = $this->getYooClient();

        return $parameters;
    }
}
